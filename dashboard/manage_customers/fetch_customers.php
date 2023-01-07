<?php
    include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/config/db_connect.php');

    $limit = 2;
    $page = 1;
    if($_POST['page'] > 1){
        $start = (($_POST['page'] - 1) * $limit);
        $page = $_POST['page'];
    }else{
        $start = 0;
    }

    $query = 'SELECT * FROM customer';

    if($_POST['search_by'] != '' && $_POST['search_term'] != ''){
        $query .= " WHERE ".$_POST['search_by']." LIKE '%".$_POST['search_term']."%'";
    }

    if($_POST['order_by'] != ''){
        $query .= " ORDER BY ".$_POST['order_by'];
    }

    if($_POST['order'] != ''){
        $query .= " ".$_POST['order'];
    }

    $query_with_limit = $query.' LIMIT '.$start.','.$limit.';';

    $result = mysqli_query($connection, $query);
    $total_records = mysqli_num_rows($result);
    $output = '
    <table id="customer_" class="responsive-table stripped centered highlight">
        <caption>Total of '.$total_records.' records found</caption>
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Email</th>
                <th>Password</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Discount</th>
                <th>Type</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tboady>';
    $result = mysqli_query($connection, $query_with_limit);
    if($total_records > 0) {
        foreach ($result as $row) {
            $output .= '
            <tr>
                <td>' . $row['customer_id'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['password'] . '</td>
                <td>' . $row['customer_name'] . '</td>
                <td>' . $row['phone_number'] . '</td>
                <td>' . $row['address'] . '</td>
                <td>' . $row['discount'] . '</td>
                <td>' . $row['type'] . '</td>
                <td>
                    <button class="update_row_btn btn waves-effect waves-light" type="button" data-customer_id="'.$row['customer_id'].'">
                        <i class="material-icons right">settings</i>
                    </button>
                </td>
                <td>
                    <button class="delete_row_btn btn waves-effect waves-light" type="button" data-customer_id="'.$row['customer_id'].'">
                        <i class="material-icons right">delete</i>
                    </button>
                </td>
            </tr>';
        }
    }else{
        $output .= '
        <tr>
            <td colspan="2">No Data Found</td>
        </tr>';
    }
    $output .= '
        </tbody>
    </table>
    <br>
    <div class="container">
        <ul class="pagination">';

    $total_links = ceil($total_records/$limit);
    $previous_link = '';
    $next_link = '';
    $page_link = '';

    if($total_links > 1){
        for($count = 1; $count <= $total_links; $count++) {
            if($page == $count){
                $page_link .= '
                <li class="active waves-effect">
                    <a class="page-link" href="#">'.$page.'</a>
                </li>';
                $previous_page = $page - 1;
                if($previous_page > 0){
                    $previous_link = '
                    <li class="waves-effect">
                        <a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_page.'">
                            <i class="material-icons">chevron_left</i>
                        </a>
                    </li>';
                }else{
                    $previous_link = '
                    <li class="disabled waves-effect">
                        <a class="page-link" href="#">
                            <i class="material-icons">chevron_left</i>
                        </a>
                    </li>';
                }
                $next_page = $page + 1;
                if($next_page > $total_links){
                    $next_link = '
                    <li class="disabled waves-effect">
                        <a class="page-link" href="#">
                            <i class="material-icons">chevron_right</i>
                        </a>
                    </li>';
                }else{
                    $next_link = '
                    <li class="waves-effect">
                        <a class="page-link" href="javascript:void(0)" data-page_number="'.$next_page.'">
                            <i class="material-icons">chevron_right</i>
                        </a>
                    </li>';
                }
            }else{
                $page_link .= '
                <li class="waves-effect">
                    <a class="page-link" href="javascript:void(0)" data-page_number="'.$count.'">'.$count.'</a>
                </li>';
            }
        }
    }

    $output .= $previous_link . $page_link . $next_link;
    $output .= '
        </ul>
    </div>';
    echo $output;