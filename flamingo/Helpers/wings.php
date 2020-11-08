<?php

/**
 * Wings the future thing.
 * It should be something like the template
 * engine for views. But we will see. :-)
 */

use Flamingo\Http\Request;

/**
 * Return CSS path
 *
 * @param $file
 * @return string
 */
function css($file) {
    global $__projectPath;

    if (isset($__projectPath)) {
        return '/' . $__projectPath . '/css/' . $file;
    }

    return '/css/' . $file;
}

/**
 * Set a pagination for a site.
 *
 * @param $object
 */
function pagination($object) {
    if ($object->currentPage() > $object->lastPage()) {
        echo "<div class='pagination-overflow'>";
        echo "This page does not have more than {$object->lastPage()} pages.";
        echo "</div>";
    }

    if ($object->hasPages()) {
        echo '<div class="pagination">';
        if ($object->currentPage() == 1) {
            echo '<a class="pagination-link disabled">Prev</a>';
        } else {
            $prevUri = route(Request::uri() . $object->previousPageUrl());
            echo '<a href="' . $prevUri . '" class="pagination-link">Prev</a>';
        }

        if ($object->hasMorePages()) {
            $nextUri = route(Request::uri() . $object->nextPageUrl());
            echo '<a href="' . $nextUri . '" class="pagination-link">Next</a>';
        } else {
            echo '<a class="pagination-link disabled">Next</a>';
        }
        echo '</div>';
    }
}