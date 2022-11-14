<?php
include '../private/codeexecution.php';
if ( !isset( $_POST[ 'actualinvoiceid' ] ) || $_POST[ 'actualinvoiceid' ] === 'N/A' ) {
    header( 'Location: webmanager.php' );
    exit();
} else {
    $localestrings = locales( 0 );
    navtop( $localestrings);
    firstinvoicecheck( $_POST[ 'actualinvoiceid' ], $_POST[ 'timestamp' ]);
};
?>
</body>

</html>