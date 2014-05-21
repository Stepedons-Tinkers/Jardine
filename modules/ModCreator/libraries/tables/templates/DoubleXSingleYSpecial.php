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

        #CREATE HEADER
        $str .="<tr >";            
                foreach ($header as $key => $value) 
                {
                   $str .="<th class='dvtCellLabel' colspan=1>$value</th>";
                }

        $str .="</tr>";
                
               
        
        
        foreach ($data as $key=>$value)
        {

            #FIRST X LABEL
            $str .="<tr><td  class='dvtCellInfo' >$key</td>";
                 
            foreach($value as $key2=>$value2)
            {
                #SECOND X LABEL
                $str .="<td  class='dvtCellInfo' >$key2</td>";
                
                #VALUE
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
