<?php
/*
 * Average Hash
 */
class AverageHash {
	/*
	 * Image Size
	 */
	const SIZE = 16;

	/*
	 * Hash process
	 *
	 * @param string $resource
	 */
	public function hash( $resource ) {
		$resize = imagecreatetruecolor( self::SIZE, self::SIZE );
		$image  = imagecreatefromstring( file_get_contents( $resource ) );
		imagecopyresampled( $resize, $image, 0, 0, 0, 0, self::SIZE, self::SIZE, imagesx( $image ), imagesy( $image ) );

		$pixels = [];
		for ( $y = 0; $y < self::SIZE; $y++ ) {
			for ( $x = 0; $x < self::SIZE; $x++ ) {
				$rgb = imagecolorsforindex( $resize, imagecolorat( $resize, $x, $y ) );
				$pixels[] = floor( ( $rgb['red'] + $rgb['green'] + $rgb['blue'] ) / 3 );
			}
		}
		imagedestroy( $resize );

		$average = floor( array_sum( $pixels ) / count( $pixels ) );

		$hash  = 0;
		$shift = 1;
		$count = 1;

		foreach ( $pixels as $value ) {
			if ( $value > $average ) {
				$hash = $hash | $shift;
				echo '<span style="width:20px;height:20px;display:inline-block;">1</span>';
			} else {
				echo '<span style="width:20px;height:20px;display:inline-block;">0</span>';
			}
			$shift = $shift << 1;

			if ( $count % self::SIZE == 0 ) {
				echo '<br>';
			}
			$count++;
		}
		return $hash;
	}
}

$hash  = new AverageHash();
$hash1 = $hash->hash( 'blackstar.jpg' );