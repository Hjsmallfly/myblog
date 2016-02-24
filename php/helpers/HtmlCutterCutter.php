<?php

/**
 * http://stackoverflow.com/questions/16583676/shorten-text-without-splitting-words-or-breaking-html-tags
 * usage: HtmlCutter::trim($str, $max_len))
 * Class HtmlCutter
 */
class HtmlCutter{

protected
    $reachedLimit = false,
    $totalLen     = 0,
    $maxLen       = 25,
    $toRemove     = array();

public static function trim($html, $maxLen = 25){
    $dom = new DomDocument();
    $dom->loadHTML($html);

    //  即实例化当前类的一个对象
    $html = new static();
    $toRemove = $html->walk($dom, $maxLen);
    // remove any nodes that passed our limit
    foreach($toRemove as $child)
        $child->parentNode->removeChild($child);

    // remove wrapper tags added by DD (doctype, html...)
    if(version_compare(PHP_VERSION, '5.3.6') < 0){
    // http://stackoverflow.com/a/6953808/1058140
        $dom->removeChild($dom->firstChild);
        $dom->replaceChild($dom->firstChild->firstChild->firstChild, $dom->firstChild);
        return $dom->saveHTML();
    }

    return $dom->saveHTML($dom->getElementsByTagName('body')->item(0));
}

protected function walk(DomNode $node, $maxLen){
    if($this->reachedLimit){
        $this->toRemove[] = $node;
    }else{
        // only text nodes should have text,
        // so do the splitting here
        if($node instanceof DomText){
            $this->totalLen += ($nodeLen =  mb_strlen($node->nodeValue));
        // use mb_strlen / mb_substr for UTF-8 support
            if($this->totalLen > $maxLen){
                $node->nodeValue = mb_substr($node->nodeValue, 0, $nodeLen - ($this->totalLen - $maxLen)) . '...';
                $this->reachedLimit = true;
            }

        }

        // if node has children, walk its child elements
        if(isset($node->childNodes))
            foreach($node->childNodes as $child)
                $this->walk($child, $maxLen);
        }

    return $this->toRemove;
}
}
