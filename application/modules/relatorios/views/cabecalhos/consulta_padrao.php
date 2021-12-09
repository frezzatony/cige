<?php
    
    

?>



<style>

    <?php 
        
        include(APPPATH.'../assets/css/print.css');
    
    ?>
    
    .style2{
        font-family: 'Open Sans','opensansb';
        font-weight: bold;
    }
    
    
    .sheet {
      overflow: visible;
      height: auto !important;
    }
</style>

<table  style="border-bottom: 1px double #959595; <?php echo (!($excel??NULL) ? ('width: 200mm;') : '');  ?>" cellspacing="0" cellpadding="0" >
   <tr >
      <td border="0" width="<?php echo (($excel??NULL) ? (0.15*100) : '15%');  ?>"  style=""  color="" align="center" rowspan="4">
         <img src="<?php echo (($localPath??NULL) ? (APPPATH.'../') : (BASE_URL))?>assets/img/logos/brasao_prefeitura.jpg" border="0" height="60" align="middle"/>
      </td>
      <td class="style2" width="<?php echo (($excel??NULL) ? (0.7*100) : '70%');  ?>" style="text-align:center; font-size: 11pt; height: 15px;" >
         <?php echo $instituicao??NULL; ?>
      </td>
      <td width="<?php echo (($excel??NULL) ? (0.15*100) : '15%');  ?>" style="font-size: 7pt; text-align: right; font-family: 'Arial';" rowspan="4" >
         <?php
           if(!($excel??NULL)){
         ?>
         Pág {page_number} de {total_pages}
         <?php
         
            }
         ?>
      </td>
   </tr>
   <tr border="0">
      <td style="font-size: 10pt; text-align:center; height: 13px;" >
         <?php echo $title??NULL; ?>
      </td>
   </tr>
   <tr>
      <td style="font-size: 8pt; text-align:center; height: 13px;" >
         <?php echo $subtitle??NULL; ?>
      </td>
   </tr>
   <tr>
      <td style="font-size: 7pt; text-align:center" >
         <?php  echo $strFiltros??NULL; ?>
      </td>
   </tr>
</table>