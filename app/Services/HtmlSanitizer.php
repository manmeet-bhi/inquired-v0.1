<?php

namespace App\Services;

class HtmlSanitizer
{
    /**
     * Whitelist of allowed HTML tags.
     */
    protected static array $allowedTags = [
        'p', 'br', 'b', 'strong', 'i', 'em', 'u', 's', 'strike',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'ul', 'ol', 'li', 'blockquote', 'code', 'pre', 'hr',
        'a', 'span', 'div',
        'table', 'thead', 'tbody', 'tfoot', 'tr', 'th', 'td'
    ];

    /**
     * Whitelist of allowed attributes per tag.
     */
    protected static array $allowedAttributes = [
        'a' => ['href', 'title', 'target', 'rel'],
        'span' => ['class'],
        'div' => ['class'],
        'p' => ['class'],
        'code' => ['class'],
        'pre' => ['class'],
        'th' => ['colspan', 'rowspan', 'scope', 'class'],
        'td' => ['colspan', 'rowspan', 'class'],
    ];

    /**
     * Allowed URI schemes for href and src.
     */
    protected static array $allowedSchemes = [
        'http', 'https', 'mailto', 'tel'
    ];

    /**
     * Clean and sanitize input HTML.
     */
    public static function clean(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        // Disable libxml errors and enable user error handling
        $previousLibXmlUseErrors = libxml_use_internal_errors(true);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        // Wrap in UTF-8 HTML boilerplate to preserve character encoding and allow partial HTML
        $wrapped = '<?xml encoding="utf-8" ?><div>' . $html . '</div>';
        
        $dom->loadHTML($wrapped, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previousLibXmlUseErrors);

        // Sanitize the root <div> children
        $root = $dom->getElementsByTagName('div')->item(0);
        if (!$root) {
            return strip_tags($html);
        }

        self::sanitizeNode($root);

        // Extract inner HTML of the wrapper div
        $cleanHtml = '';
        foreach ($root->childNodes as $child) {
            $cleanHtml .= $dom->saveHTML($child);
        }

        return trim($cleanHtml);
    }

    /**
     * Recursively sanitize DOM nodes.
     */
    protected static function sanitizeNode(\DOMNode $node): void
    {
        if ($node->nodeType === XML_ELEMENT_NODE) {
            $tagName = strtolower($node->nodeName);

            // If tag is not allowed, remove the node or replace with text content
            if (!in_array($tagName, self::$allowedTags)) {
                // If it's a dangerous tag, remove entirely along with its children
                if (in_array($tagName, ['script', 'style', 'iframe', 'object', 'embed', 'applet', 'meta', 'link', 'form', 'input', 'button'])) {
                    $node->parentNode->removeChild($node);
                    return;
                }

                // For other tags, unwrap text children
                $fragment = $node->ownerDocument->createDocumentFragment();
                while ($node->childNodes->length > 0) {
                    $child = $node->childNodes->item(0);
                    self::sanitizeNode($child);
                    $fragment->appendChild($child);
                }
                $node->parentNode->replaceChild($fragment, $node);
                return;
            }

            // Sanitize attributes on allowed tag
            if ($node->hasAttributes()) {
                $attributesToRemove = [];
                $allowedForTag = self::$allowedAttributes[$tagName] ?? [];

                foreach ($node->attributes as $attr) {
                    $attrName = strtolower($attr->nodeName);
                    $attrValue = trim($attr->nodeValue);

                    // Block any inline event handler (starts with 'on')
                    if (str_starts_with($attrName, 'on')) {
                        $attributesToRemove[] = $attrName;
                        continue;
                    }

                    // Check if attribute is in whitelist for this tag
                    if (!in_array($attrName, $allowedForTag)) {
                        $attributesToRemove[] = $attrName;
                        continue;
                    }

                    // For 'href', validate protocol scheme
                    if ($attrName === 'href') {
                        $scheme = strtolower(parse_url($attrValue, PHP_URL_SCHEME) ?? '');
                        if (!empty($scheme) && !in_array($scheme, self::$allowedSchemes)) {
                            $attributesToRemove[] = $attrName;
                            continue;
                        }

                        // Protect against javascript: or data: URIs
                        if (preg_match('/^(javascript|data|vbscript):/i', $attrValue)) {
                            $attributesToRemove[] = $attrName;
                            continue;
                        }
                    }

                    // For 'target="_blank"', enforce 'rel="noopener noreferrer"' for security
                    if ($attrName === 'target' && strtolower($attrValue) === '_blank') {
                        $node->setAttribute('rel', 'noopener noreferrer');
                    }
                }

                foreach ($attributesToRemove as $attrName) {
                    $node->removeAttribute($attrName);
                }
            }
        }

        // Process children
        $children = [];
        foreach ($node->childNodes as $child) {
            $children[] = $child;
        }

        foreach ($children as $child) {
            if ($child->parentNode) {
                self::sanitizeNode($child);
            }
        }
    }
}
