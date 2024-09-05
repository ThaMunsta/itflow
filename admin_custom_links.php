<?php

// Default Column Sortby Filter
$sort = "custom_link_name";
$order = "ASC";

require_once "inc_all_admin.php";


//Rebuild URL
$url_query_strings_sort = http_build_query($get_copy);

$sql = mysqli_query(
    $mysqli,
    "SELECT SQL_CALC_FOUND_ROWS * FROM custom_links
    WHERE custom_link_name LIKE '%$q%'
    ORDER BY $sort $order LIMIT $record_from, $record_to"
);

$num_rows = mysqli_fetch_row(mysqli_query($mysqli, "SELECT FOUND_ROWS()"));

?>

    <div class="card card-dark">
        <div class="card-header py-2">
            <h3 class="card-title mt-2"><i class="fas fa-fw fa-external-link-alt mr-2"></i>Custom Links</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addLinkModal"><i class="fas fa-plus mr-2"></i>New Link</button>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-4 mb-2">
                    <form autocomplete="off">
                        <div class="input-group">
                            <input type="search" class="form-control" name="q" value="<?php if (isset($q)) { echo stripslashes(nullable_htmlentities($q)); } ?>" placeholder="Search Links">
                            <div class="input-group-append">
                                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-8">
                </div>
            </div>

            <hr>
            <div class="table-responsive-sm">
                <table class="table table-striped table-borderless table-hover">
                    <thead class="text-dark <?php if ($num_rows[0] == 0) { echo "d-none"; } ?>">
                    <tr>
                        <th><a class="text-dark" href="?<?php echo $url_query_strings_sort; ?>&sort=custom_link_name&order=<?php echo $disp; ?>">Name</a></th>
                        <th><a class="text-dark" href="?<?php echo $url_query_strings_sort; ?>&sort=custom_link_uri&order=<?php echo $disp; ?>">URI</a></th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    while ($row = mysqli_fetch_array($sql)) {
                        $custom_link_id = intval($row['custom_link_id']);
                        $custom_link_name = nullable_htmlentities($row['custom_link_name']);
                        $custom_link_uri = nullable_htmlentities($row['custom_link_uri']);
                        $custom_link_icon = nullable_htmlentities($row['custom_link_icon']);

                        ?>
                        <tr>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#editLinkModal<?php echo $custom_link_id; ?>">
                                    <i class="fa fa-fw fa-<?php echo $custom_link_icon; ?> mr-2"></i>
                                    <?php echo $custom_link_name;?>
                                </a>
                            </td>
                            <td><?php echo $custom_link_uri; ?></td>
                            <td>
                                <div class="dropdown dropleft text-center">
                                    <button class="btn btn-secondary btn-sm" type="button" data-toggle="dropdown">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editLinkModal<?php echo $custom_link_id; ?>">
                                            <i class="fas fa-fw fa-edit mr-2"></i>Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger text-bold confirm-link" href="post.php?delete_custom_link=<?php echo $custom_link_id; ?>">
                                            <i class="fas fa-fw fa-trash mr-2"></i>Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <?php

                        require "admin_custom_link_edit_modal.php";


                    }

                    ?>

                    </tbody>
                </table>
            </div>
            <?php require_once "pagination.php";
 ?>
        </div>
    </div>

<?php
require_once "admin_custom_link_add_modal.php";

require_once "footer.php";

