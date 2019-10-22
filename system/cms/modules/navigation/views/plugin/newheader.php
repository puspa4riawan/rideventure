<?php     

    function subsubs($links, $string='', $ul=false){
        $string = $string;
        if($ul){
            $string .= '<ul>';
        }
        foreach($links as $link){
            $href = site_url($link['uri']);
            if(in_array($link['link_type'],array('page','url'))){
                $href = $link['url'];
            }
            $string .= '<li>';
            $string .= '<a href="'.$href.'">'.$link['title'].'</a>';
            if($link['children']){                
                $string = subsubs($link['children'], $string, true);
            }
            $string .= '</li>';
        }

        if($ul){
            $string .= '</ul>';
        }
        return $string;
    }    
?>
<ul id="mainNav">
    <?php echo subsubs($links);?>
</ul>