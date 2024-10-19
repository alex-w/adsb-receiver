<?php
    ///////////////////////
    // UPGRADE TO V2.8.8
    ///////////////////////

    // --------------------------------------------------------
    // Updates the version to 2.8.8
    // --------------------------------------------------------

    $results = upgrade();
    exit(json_encode($results));

    function upgrade() {
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."common.class.php");
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."settings.class.php");

        $common = new common();
        $settings = new settings();

        try {
            // Update the version and patch settings
            $common->updateSetting("version", "2.8.8");
            $common->updateSetting("patch", "");

            // The upgrade process completed successfully
            $results['success'] = TRUE;
            $results['message'] = "Upgrade to v2.8.8 successful.";
            return $results;

        } catch(Exception $e) {
            // Something went wrong during this upgrade process
            $results['success'] = FALSE;
            $results['message'] = $e->getMessage();
            return $results;
        }
    }
?>

