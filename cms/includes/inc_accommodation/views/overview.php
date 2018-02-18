<?php
$max_coulmns_dd = generate_num_dd(1, MAX_COLUMNS);
$content_rows = fetch_all("SELECT `id`, `rank`
        FROM `content_row`
        WHERE `page_meta_data_id` = '{$page_meta_data_id}'
        ORDER BY `rank`");

    $content_view = '';

    if( !empty($content_rows) ) 
    {
        foreach ($content_rows as $inx => $content_row)
        {

$content_view .= <<< H

        <div class="row sortable-item clear" id="row-{$inx}">
H;

            $rank = $inx+1;

            $row_columns = fetch_all("SELECT `content`, `css_class`, `rank` FROM `content_column` WHERE `content_row_id` = '{$content_row['id']}' ORDER BY `rank`");

            foreach ($row_columns as $cindx => $row_column)
            {
                $content_view .= <<< H

                <div class="{$row_column['css_class']} res-col sortable-item" id="col-{$inx}-{$cindx}">
                    <ul class="action">
                        <li><input type="checkbox" class="col-merge" value="1"><li/>
                        <li><a href="#" title="drag to change the rank" class="move-col"><i class="glyphicon glyphicon-move"></i></a><li/>
                        <li><a href="#" data-to-remove=".res-col" title="click to remove section"  class="remove-col"><i class="glyphicon glyphicon-remove"></i></a><li/>
                    </ul>
                    <div class="editable-column-content" title="Click to edit this content section.">
                        <textarea id="content-{$inx}-{$cindx}" name="content-{$inx}-text[]">{$row_column['content']}</textarea>
                    </div>
                    <input type="hidden" value="{$row_column['rank']}" class="col-rank" name="content-{$inx}-rank[]">
                    <input type="hidden" value="{$row_column['css_class']}" name="content-{$inx}-class[]" class="col-cls">
                </div>

H;
            }

           $content_view .= <<< H
            <input type="hidden" value="{$inx}" name="row-index[]">
            <input type="hidden" value="{$content_row['rank']}" name="row-rank[]" class="row-rank">
            <div class="clear"></div>
            <ul class="roww action">
                <li><a href="#" title="add new column to this row" class="add-col"><i class="glyphicon glyphicon-plus-sign"></i></a><li/>
                <li><a href="#" title="drag to change the rank" class="move-col"><i class="glyphicon glyphicon-move"></i></a><li/>
                <li><a href="#" title="click to remove row" data-to-remove=".row"  class="remove-col"><i class="glyphicon glyphicon-remove"></i></a><li/>
            </ul>
        </div>

H;
        }
    }

    $main_content = <<< HTML
        
        <p>Add new row with &nbsp;<select name="column-num" id="column-num" class="column-num">
            {$max_coulmns_dd}
        </select> &nbsp;columns. <button type="button" class="add-row">Go</button></p>


        <div id="grid-holder" class="grid-holder">
            
            <script type="text/html" id="row-template">
                    <div class="row sortable-item clear" id="row-<%= rowIndex %>">
                        <%
                            var colCls = 'col-xs-12';
                            var maxCols = app.config.maxCols;
                           if(numColumns > 1)  colCls = colCls+' col-sm-'+(maxCols/2);
                            if(numColumns > 1) colCls = colCls+' col-md-'+(maxCols/numColumns);
                        %>
                        <%  for (var i=1; i <= numColumns; i++){ i = (colIndex) ? colIndex : i %>
                            <div class="<%= colCls %> res-col sortable-item" id="col-<%= rowIndex %>-<%= i %>">
                                <ul class="action">
                                    <li><input type="checkbox" class="col-merge" value="1"><li/>
                                    <li><a href="#" title="drag to change the rank" class="move-col"><i class="glyphicon glyphicon-move"></i></a><li/>
                                    <li><a href="#" title="click to remove section" data-to-remove=".res-col"  class="remove-col"><i class="glyphicon glyphicon-remove"></i></a><li/>
                                </ul>
                                <div class="editable-column-content" title="Click to edit this content section.">
                                    <textarea id="content-<%= rowIndex %>-<%= i %>" name="content-<%= rowIndex %>-text[]">Column <%= i %></textarea>
                                </div>
                                <input type="hidden" value="<%= i %>" class="col-rank" name="content-<%= rowIndex %>-rank[]">
                                <input type="hidden" value="<%= colCls %>" name="content-<%= rowIndex %>-class[]" class="col-cls">
                                
                            </div>
                        <% }%>

                        <input type="hidden" value="<%= rowIndex %>" name="row-index[]">
                        <input type="hidden" value="<%= rowIndex + 1 %>" name="row-rank[]" class="row-rank">
                        <div class="clear"></div>
                        <ul class="roww action">
                            <li><a href="#" title="add new column to this row" class="add-col"><i class="glyphicon glyphicon-plus-sign"></i></a><li/>
                            <li><a href="#" title="drag to change the rank" class="move-col"><i class="glyphicon glyphicon-move"></i></a><li/>
                            <li><a href="#" title="click to remove row" data-to-remove=".row"  class="remove-col"><i class="glyphicon glyphicon-remove"></i></a><li/>
                        </ul>
                    </div>
            </script>
            {$content_view}
        </div>

        
HTML;

?>