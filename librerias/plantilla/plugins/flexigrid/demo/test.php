<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>

        <link rel="stylesheet" type="text/css" href="../css/flexigrid.pack.css" />
        <script type="text/javascript"
            src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">
			</script>
        <script type="text/javascript" src="../js/flexigrid.pack.js"></script>
    </head>
    <body>

        <table class="flexme3" style="display: none">
		</table>



        <script type="text/javascript">


            $(".flexme3").flexigrid({
                url : 'post-xml.php',
                dataType : 'xml',
                colModel : [ {
                    display : 'ISO',
                    name : 'iso',
                    width : 40,
                    sortable : true,
                    align : 'center'
                    }, {
                        display : 'Name',
                        name : 'name',
                        width : 180,
                        sortable : true,
                        align : 'left'
                    }, {
                        display : 'Printable Name',
                        name : 'printable_name',
                        width : 120,
                        sortable : true,
                        align : 'left'
                    }, {
                        display : 'ISO3',
                        name : 'iso3',
                        width : 130,
                        sortable : true,
                        align : 'left',
                        hide : true
                    }, {
                        display : 'Number Code',
                        name : 'numcode',
                        width : 80,
                        sortable : true,
                        align : 'right'
                } ],
                buttons : [ {
                    name : 'Add',
                    bclass : 'add',
                    onpress : test
                    }, {
                        name : 'Delete',
                        bclass : 'delete',
                        onpress : test
                    }, {
                        separator : true
                } ],
                searchitems : [ {
                    display : 'ISO',
                    name : 'iso'
                    }, {
                        display : 'Name',
                        name : 'name',
                        isdefault : true
                } ],
                sortname : "iso",
                sortorder : "asc",
                usepager : true,
                title : 'Countries',
                useRp : true,
                rp : 15,
                showTableToggleBtn : true,
                width : 700,
                height : 200
            });      

            function test(com, grid) {
                if (com == 'Delete') {
                    confirm('Delete ' + $('.trSelected', grid).length + ' items?')
                } else if (com == 'Add') {
                    alert('Add New Item');
                }
            }
        </script>
    </body>
</html>