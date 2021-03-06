<?php
/**
 * Filesystem Class.
 * @since 2.0.6
 */
class Over_FL_Filesystem extends FL_Filesystem {

  function file_get_contents( $path ) {
    return file_get_contents( $path );
  }

  function file_exists( $path ) {
    return file_exists( $path );
  }
  
  function file_put_contents( $path, $contents ) {
    if ( file_exists( $path ) ) {
      return true;
    }
    
    return file_put_contents( $path, $contents );
  }
}
