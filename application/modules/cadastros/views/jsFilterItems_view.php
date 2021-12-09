    
    
    var actionMenuContainer = $('div.cadastro-actionmenu');
    var filtersContainer = $('div.cadastro-filter');
    var gridItemsContainer = $('div.cadastro-griditems');
    
    
    <?php
        $bsgrid = ($idGridItems??NULL) ? '$(\'#'.$idGridItems.'\')' : '$(\'div.grid-items-cadastro\')';
        
    ?>
    var bsGrid = <?php echo $bsgrid; ?>;
    
    
    var options = {
        bsgrid  :   [
           bsGrid, 
        ],
        
    };
    
    var gridItemsHeight = $(window).height()-
        (mainmenu.outerHeight() + headerPage.outerHeight() + footer.outerHeight() + actionMenuContainer.outerHeight() + filtersContainer.outerHeight())
        - 120
    
    bsGrid.height(gridItemsHeight);
     
    $('div.grid-items-cadastro').bsgrid({
        'checkbox'              :   true,
        'rows_by_bodyheight'    :   true,
        'rowOnDoubleClick'      :   function(e,row,container,plugin){
            _cadastros_editItem({
                'url'       :   row.attr('href'),
            });            
            
        },
        'rowOnToggleSelect'     :   function(row,container,plugin){
            _cadastros_onToggleGridRow(plugin.getSelectedRows(container));
            
        },  
    });
    
    $('div.filter').ci_filter({
        'recipient'     :   $('div.grid-items-cadastro'),
        'afterRun'      :   function(container,plugin){
            _cadastros_init(options);
        }
    });