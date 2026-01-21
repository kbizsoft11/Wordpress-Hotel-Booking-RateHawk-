<?php
 
if ( ! class_exists( 'WP_Background_Process' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-background-process.php';
}

class OTA_Import_Hotel_Process extends WP_Background_Process {

    protected $action = 'ota_import_hotel';

    protected function task( $item ) {

        if ( empty( $item['hotel_id'] ) ) {
            return false;
        }

        // Call your existing import function
        ota_import_hotel_by_id(
            $item['hotel_id'],
            $item['check_in'],
            $item['check_out'],
            $item['adults'],
            $item['children'],
            $item['lang'],
            $item['currency']
        );

        return false; // Remove from queue
    }

    protected function complete() {
        parent::complete();
        error_log('OTA Hotel Import: All tasks completed.');
    }
}
