    <div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
<?php
foreach($menu_list as $entry){
    if($entry->s_no == $service) {
?>
            <li><a href="/cdol<?=$entry->m_url?>"><?=$entry->m_title?></a></li>
<?php
    }
}
?>
        </ul>
    </div><!--/.sidebar-offcanvas-->
