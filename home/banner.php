<!-- text with solid background -->
<?php
if (!empty($top_banner)) {
    foreach ($top_banner as $item) {
        echo '
        <div class="p-4 p-md-5 mb-4 text-white rounded" style="background-color: ' . $item['bgColor'] . '">';
        echo '
            <div class="col-md-6 px-0">';
        echo '
                <h1 class="' . $item['h1Cls'] . '">' . $item['h1Text'] . '</h1>';
        echo '
                <p class="' . $item['pCls'] . '">' . $item['pText'] . '</p>';
        echo '
                <p class="' . $item['pLinkCls'] . '"><a href="' . $item['LinkUrl'] . '" class="' . $item['LinkCls'] . '">' . $item['LinkText'] . '</a></p>';
        echo '
            </div>';
        echo '
        </div>';
    }
}
?>


