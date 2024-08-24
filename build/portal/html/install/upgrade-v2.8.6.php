<?php
    ///////////////////////
    // UPGRADE TO V2.8.6
    ///////////////////////

    // --------------------------------------------------------
    // Updates the version setting to 2.8.6
    // --------------------------------------------------------

    $results = upgrade();
    exit(json_encode($results));

    function upgrade() {
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."common.class.php");
        require_once($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR."settings.class.php");

        $common = new common();
        $settings = new settings();

        try {

            // Add enable ACARS setting
            $common->addSetting('enableAcars', FALSE);
            $common->addSetting('acarsserv_database', "");

            // Update the version and patch settings
            $common->updateSetting("version", "2.8.6");
            $common->updateSetting("patch", "");

            // The upgrade process completed successfully
            $results['success'] = TRUE;
            $results['message'] = "Upgrade to v2.8.6 successful.";
            return $results;

        } catch(Exception $e) {
            // Something went wrong during this upgrade process
            $results['success'] = FALSE;
            $results['message'] = $e->getMessage();
            return $results;
        }
    }
?>
