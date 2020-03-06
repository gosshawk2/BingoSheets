    <?php

    function displayMenu($menu_with_many_levels,$menuHTML)
    {

        $menuHTML .= "<UL>";
        foreach($menu_with_many_levels as $menuTitle => $menuLinkUrl)
        {
            $closeList = FALSE;
            if (is_array($menuLinkUrl))
            {
                $menuHTML .= "<LI><a href=".chr(34)."#".chr(34).">";
                $menuHTML .= $menuTitle . "</a>";
                $menuHTML .= displayMenu($menuLinkUrl,"");
                $closeList = TRUE;

            }
            else
            {
                $menuHTML .= "<li><a href=".chr(34).$menuLinkUrl.chr(34).">";
                $menuHTML .= $menuTitle . "</a></li>";

            }


        }
        if ($closeList===TRUE)
        {
            $menuHTML .= '</LI></UL>';
        }
        else
        {
            $menuHTML .= '</ul>';
        }
        return $menuHTML;

    }


      $outputHTML = "";
      $outputHTML = displayMenu($menu,$outputHTML);
        echo $outputHTML;
    ?>

