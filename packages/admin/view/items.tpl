<?php include framework::resolve("packages/base/view/header.tpl"); ?>
<?php include framework::resolve("packages/admin/view/menu.tpl"); ?>

<div id="section-body" class="container" style="padding-right: 20px;">
    <div class="row">
        <div class="col-lg-12">

            <!--section: items table-->
            <h1>List of items</h1>
            <div class="text-right">
                <a href = "<?php echo framework::link_to("admin/items"); ?>">All items</a> |
                <?php $kk = 0; foreach($languages as $key => $langx): ?>
                    <?php if ($kk > 0) echo "|"; $kk++; ?>
                    <?php if ($i18n_lang_progress[$langx['CODE']]['PERCENT'] > 0): ?>
                        <a href ="<?php echo framework::link_to("admin/items")."&lang=".$langx['CODE'];?>"><?php echo $langx['NAME']; ?></a> (<?php echo $i18n_lang_progress[$langx['CODE']]['PERCENT']; ?>%)
                    <?php else: ?>
                        <?php echo $langx['NAME']; ?> (0%)
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Long name</th>
                            <th title="Width, Height, Base, Weight">Size</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th width="130"></th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php if (!is_null($items)): ?>
                                    <?php foreach ($items as $key => $item): ?>
                                            <tr>
                               
                                                <td class="text-left">
                                                  <?php for($i=1; $i<=5; $i++): ?>
                                                        <?php if ($item['IMAGE'.$i]!=''):?>
                                                            <img width="32" height="32" src="<?php echo framework::resolve("static/images/items/{$item['IMAGE'.$i]}"); ?>" alt="">
                                                            <?php break; ?>
                                                        <?php else: ?>
                                                            <?php if ($i<5) continue; ?>
                                                            <div style="width:32px;height:32px;float:left;">&nbsp;</div>
                                                        <?php endif;?>
                                                    <?php endfor; ?>

                                                <?php if (!empty($item['NAMELONG'])) echo $item['NAMELONG']; else if ($item['NAMESHORT'] != '') echo $item['NAMESHORT']." <label style= \"color:red;\">[missing the long name]</label>"; ?>

                                                </td>
                                                <td><?php echo $item['WIDTH']; ?>,<?php echo $item['HEIGHT']; ?>,<?php echo $item['BASE']; ?>,<?php echo $item['WEIGHT']; ?></td>
                                                <td class="text-right">$<?php echo $item['PRICE']; ?></td>
                                                <td><?php echo $item['STATUS']; ?></td>
                                                <td><a href="<?php echo framework::link_to("admin/edit_category"),"&id={$item['CATEGORY']}"?>"><?php echo $item['CATEGORYNAME']; ?></a></td>
                                                <td><?php echo $item['STOCK']; ?></td>
                                                <td class="text-right" width="130">
                                                <a href="<?php echo framework::link_to('admin/edit_item'); ?>&id=<?php echo $item['ID']; ?><?php if (!empty($current_lang)) echo '&lang='.$current_lang; ?>" class="btn btn-default btn-mini"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                                                <a href = "<?php echo framework::link_to("admin/del_item"); ?>&id=<?php echo  $item['ID']; ?><?php if (!empty($current_lang)) echo '&lang='.$current_lang; ?>" onclick = 'return confirm("Delete the item *<?php echo $item['NAMELONG']; ?>*?")' class="btn btn-default btn-mini"><span class="glyphicon glyphicon-trash"></span>Delete</a>
                                                </td>
                                            </tr>
                                    <?php endforeach; ?>
                            <?php endif; ?>
                    </tbody>
            </table>

            <div class="text-center">
                    <br/>
                    <a href="<?php echo framework::link_to('admin/add_item'); ?><?php if (!empty($current_lang)) echo '&lang='.$current_lang; ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-plus"></span> New item</a>
            </div>
        </div>
    </div>
</div>

<?php include_once framework::resolve('packages/admin/view/footer.tpl'); ?>