<?php
class DoubleXSingleY
{   
    public function __construct()
    {
        
    }
    
    public function generateDisplay($data2,$mode) 
    {

        $header = parseHeader($data2['data'][0]['cornerlabel']);
        
        $data = $data2['fields'];

        $str = "<div style='overflow:scroll; max-height:650px;'>";
        $str .="<table class='small' border=0 cellpadding=5 cellspacing=0 width='100%' align='center'>";
        $str .="<tbody>";
        $str .="<tr >
                <th class='dvtCellLabel' style='padding-left:50px; padding-right:50px;' rowspan=1>$header->h1</th>
                <th class='dvtCellLabel' rowspan=1>$header->h2</th>";
                
               
        foreach($data as $key=>$value)
        {
            foreach($value as $key2=>$value2)
            {
            
                foreach($value2 as $key3=>$value3)
                {   #Y HEADER                          
                    $str .="<th class='dvtCellLabel' colspan=2>$key3</th>";

                }   
                
            }
            break;
        }
        
        foreach ($data as $key=>$value)
        {

            #FIRST X LABEL
            $str .="<tr><td  class='dvtCellInfo' >$key</td>";
         
            
            
            foreach($value as $key2=>$value2)
            {
                #SECOND X LABEL
                $str .="<td  class='dvtCellInfo' >$key2</td>";
                

                foreach($value2 as $key3=>$value3)
                {   
                    $str .="<td  class='dvtCellInfo'>$value3</td>";                                                            
                }   
            }
        }
        $str .="</tr>";
        $str .= "</tbody>";
        $str .="</table></div>";
        $str .="</div>"; 


        return $str;
    }
    
}

?>
