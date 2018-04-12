<div class="panel-heading">
    <button type="button" class="btn btn-primary address_add_btn" tbl_id="0">Add New</button>
</div>
<div class="panel-body">
    <div class="table-responsive">
    <form id="frm_table_list" method="POST" >
    <input type="hidden" name="action" id="action" value="addressBook">
    <?php echo CHtml::hiddenField('currentController','store')?> 
    <input type="hidden" name="tbl" id="tbl" value="address_book">
    <input type="hidden" name="clear_tbl"  id="clear_tbl" value="clear_tbl">
    <input type="hidden" name="whereid"  id="whereid" value="id">
    <input type="hidden" name="slug" id="slug" value="store/addressbook">
        <table id="table_list" class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 80% !important;">Address</th>
                <!--    <th>Location Name</th>
                    <th>Default</th>  -->
                    <th>Action</th>
                </tr>
            </thead>
            <tbody> 
            </tbody>
        </table>
     </form>   
    </div>
</div>