<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. 

class The4Helper {
	
	/**
	 * Sanitize allower HTML
	 * @return string HTML
	 */
	
	public static function ksesHTML( $content, $isReturn = false )
	{
		$aAllowedTags = [
            'a'      => [
                'href'  => [],
                'style'  => [
                    'color' => []
                ],
                'title'  => [],
                'target' => [],
                'class'  => [],
                'id' => [],
                'rel' => [],
                'data-prod' => []
            ],
            'img'      => [
                'src'  => [
                    
                ],
                'alt' => [],
                'class'  => [],
                'width' => [],
                'height' => [],
                'srcset' => [],
                'size' => [],
                'data-sizes' => [],
                'data-srcset' => [],
                'data-src' => [],
                'data-widths' => [],
            ],
            'div'    => [
            	'class' => [],
            	'id' => [],
            	'data-attribute' => [],
            	'data-args' => [],
            	'style'  => [
                    'width' => [],
                    'height' => [],
                ],
            ],
             'aside'    => [
                'class' => [],
                'id' => [],
            ],
            'p'    => ['class' => []],
            'br'    => ['class' => []],
            'h1'    => ['class' => []],
            'h2'    => ['class' => []],
            'h3'    => ['class' => []],
            'h4'    => ['class' => []],
            'h5'    => ['class' => []],
            'ul'    => ['class' => []],
            'li'    => ['class' => []],
            'bdi'    => ['class' => []],
            'title'    => ['id' => []],
            'svg'    => [
            	'class' => [],
            	'xmlns' => [],
            	'viewbox' => [],
            	'role' => [],
            	'width' => [],
            	'height' => [],
            	'aria-labelledby' => []
            ],
            'path'    => [
            	'd' => [],
            	'fill' => [],
            ],
            'g'    => [
            	'fill' => [],
            ],
            'button'    => [
            	'class' => [],
            	'data-id' => []
            ],
            'i'    => ['class' => []],
            'span'    => [
            	'class' => [],
            	'style'  => [
                    'color' => [],
                    'width' => [],
                    'height' => [],
                ],
                'data-variation' => []
            ],
        ];
       
        if ( ! $isReturn ) {
            echo wp_kses(wp_unslash($content), $aAllowedTags);
        } else {
            return wp_kses(wp_unslash($content), $aAllowedTags);
        }
    }

}