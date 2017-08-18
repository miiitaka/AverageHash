<?php
class AverageHash {
	/*
	 * Image Size
	 */
	const SIZE = 16;

	/*
	 * Constructor
	 */
	public function __constructor() {

	}

	/*
	 * Hash preprocess
	 *
	 * @param string $resource
	 */
	public function hash( $resource ) {
		$resize = imagecreatetruecolor( static::SIZE, static::SIZE );
		$image  = imagecreatefromstring( file_get_contents( $resource ) );
		imagecopyresampled( $resize, $image, 0, 0, 0, 0, static::SIZE, static::SIZE, imagesx( $image ), imagesy( $image ) );

		$pixels = [];
		for ( $y = 0; $y < static::SIZE; $y++ ) {
			for ( $x = 0; $x < static::SIZE; $x++ ) {
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
				echo 1;
			} else {
				echo 0;
			}
			$shift = $shift << 1;

			if ( $count % static::SIZE == 0 ) {
				echo '<br>';
			}
			$count++;
		}
		return $hash;
	}
}

$hash  = new AverageHash();
$hash1 = $hash->hash( 'lenna.png' );