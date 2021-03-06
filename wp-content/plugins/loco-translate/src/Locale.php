<?php
/**
 * Represents a WordPress locale
 * 
 * @property string $lang
 * @property string $region
 * @property string $variant
 */
class Loco_Locale implements JsonSerializable {

    /**
     * Language subtags
     * @var array
     */
    private $tag;

    /**
     * Cached composite tag 
     * @var string
     */
    private $_tag;

    /**
     * Cached icon css class
     * @var string
     */
    private $icon;

    /**
     * Name in English
     * @var string
     */
    private $name;
    
    /**
     * Name in language of self
     * @var string
     */
    private $_name;

    /**
     * Cache of raw plural data 
     * @var array
     */
    private $plurals;

    /**
     * Validity cache
     * @var bool
     */
    private $valid;

    /**
     * @param string
     * @return Loco_Locale
     */
    public static function parse( $tag ){
        $locale = new Loco_Locale('');
        try {
            $locale->setSubtags( loco_parse_wp_locale($tag) );
        }
        catch( Exception $e ){
            // isValid should return false
        }
        do_action( 'loco_parse_locale', $locale, $tag );
        return $locale;
    }



    /**
     * Construct from subtags NOT from composite tag. See self::parse
     * Note that this skips normalization and validation steps
     * @param string
     * @param string
     * @param string
     */
    public function __construct( $lang = '', $region = '', $variant = '' ){
        if( 1 == func_num_args() && isset($lang[3]) ){
            throw new BadMethodCallException('Did you mean Loco_Locale::parse('.var_export($lang,1).') ?');
        }
        $this->tag = compact('lang','region','variant');
    }


    /**
     * Allow read access to subtags
     * @internal 
     * @param string
     * @return string
     */
    public function __get( $t ){
        return isset($this->tag[$t]) ? $this->tag[$t] : '';
    }


    /**
     * Allow write access to subtags
     * @internal
     * @param string
     * @param string
     * @return void
     */
    public function __set( $t, $s ){
        if( isset($this->tag[$t]) ){
            $this->tag[$t] = $s;
            $this->setSubtags( $this->tag );
        }
    }


    /**
     * Set subtags as produced from loco_parse_wp_locale
     * @param string[]
     * @return Loco_Locale
     */
    public function setSubtags( array $tag ){
        $this->valid = false;
        $default = array( 'lang' => '', 'region' => '', 'variant' => '' );
        // disallow setting of unsupported tags
        if( $bad = array_diff_key($tag, $default) ){
            throw new Loco_error_LocaleException('Unsupported subtags: '.implode(',',$bad) );
        }
        $tag += $default;
        // language tag is minimum requirement
        if( ! $tag['lang'] ){
            throw new Loco_error_LocaleException('Locale must have a language');
        }
        // no UN codes in Wordpress
        if( preg_match('/^\\d+$/',$tag['region']) ){
            throw new Loco_error_LocaleException('Numeric regions not supported');
        }
        // non-standard variant code. e.g. formal/informal
        if( is_array($tag['variant']) ){
            $tag['variant'] = implode('_',$tag['variant']);
        }
        // normalize case
        $tag['lang'] = strtolower($tag['lang']);
        $tag['region'] = strtoupper($tag['region']);
        $tag['variant'] = strtolower($tag['variant']);
        // set subtags and invalidate cache of language tag
        $this->tag = $tag;
        $this->_tag = null;
        $this->icon = null;
        $this->valid = true;

        return $this;
    }


    /**
     * @return Loco_Locale
     */
    public function normalize(){
       try {
           $this->setSubtags( $this->tag );
       }
       catch( Loco_error_LocaleException $e ){
           $this->_tag = '';
           $this->icon = null;
           $this->name = 'Invalid locale';
           $this->_name = null;
       }
       return $this;
    }


    /**
     * @return string
     */    
    public function __toString(){
        $str = $this->_tag;
        if( is_null($str) ){
            $str = implode('_',array_filter($this->tag));
            $this->_tag = $str;
        }
        return $str;
    }


    /**
     * @param bool whether to get name in current display language
     * @return string | null
     */    
    public function getName( $translate = true ){
        $name = $this->name;
        // use canonical native name only when current language matches
        // deliberately not matching whole tag such that fr_CA would show native name of fr_FR
        if( $translate ){
            $locale = self::parse( function_exists('get_user_locale') ? get_user_locale() : get_locale() );
            if( $this->lang === $locale->lang && $this->_name ){
                $name = $this->_name;
            }
            /*/ Note that no dynamic translation of English name is performed, but can be filtered with loco_parse_locale
            else {
                $name = __($name,'loco-translate-languages');
            }*/
        }
        if( is_string($name) && '' !== $name ){
            return $name;
        }
        return null;
    }


    /**
     * Get canonical native name as defined by WordPress
     * @return string | null
     */    
    public function getNativeName(){
        $name = $this->_name;
        if( is_string($name) && '' !== $name ){
            return $name;
        }
        return null;
    }


    /**
     * @return string
     */    
    public function getIcon(){
        $icon = $this->icon;
        if( is_null($icon) ){
            $tag = array();
            if( ! $this->tag['lang'] ){
                $tag[] = 'lang lang-zxx';
            }
            foreach( $this->tag as $class => $code ){
                if( $code ){
                    $tag[] = $class.' '.$class.'-'.$code;
                }
            }
            $icon = strtolower( implode(' ',$tag) );
            $this->icon = $icon;
        }
        return $icon;
    }


    /**
     * @param string CSS icon name
     * @return Loco_Locale
     */
    public function setIcon( $css ){
        if( $css ){
            $this->icon = (string) $css;
        }
        else {
            $this->icon = null;
        }
        return $this;
    }


    /**
     * @param string
     * @param string
     * @return Loco_Locale
     */
    public function setName( $english_name, $native_name = '' ){
        $this->name = apply_filters('loco_locale_name', $english_name, $native_name );
        $this->_name = (string) $native_name;
        return $this;
    }


    /**
     * Test whether locale is valid
     * @return bool
     */    
    public function isValid(){
        if( is_null($this->valid) ){
            $this->normalize();
        }
        return $this->valid;
    }


    /**
     * Resolve this locale's "official" name from WordPress's translation api
     * @param Loco_api_WordPressTranslations 
     * @return string English name currently set
     */    
    public function fetchName( Loco_api_WordPressTranslations $api ){
        $tag = (string) $this;
        // pull from WordPress translations API if network allowed
        $locale = $api->getLocale($tag);
        if( $locale ){
            $this->setName( $locale->getName(false), $locale->getNativeName() );
        }
        return $this->getName(false);
    }


    /**
     * Resolve this locale's name from compiled Loco data
     * @return string English name currently set
     */
    public function buildName(){
        // should at least have a language or not valid
        if( $this->isValid() ){
            $code = $this->tag['lang'];
            $db = Loco_data_CompiledData::get('languages');
            if( $name = $db[$code] ){
                // if variant is present add only that in brackets (no lookup required)
                if( $code = $this->tag['variant'] ){
                    $name .= ' ('.ucfirst($code).')';
                }
                // else add region in brackets if present
                else if( $code = $this->tag['region'] ){
                    $db = Loco_data_CompiledData::get('regions');
                    if( $extra = $db[$code] ){
                        $name .= ' ('.$extra.')';
                    }
                    else {
                        $name .= ' ('.$code.')';
                    }
                }
                $this->setName( $name );
            }
        }
        else {
            $this->setName( __('Invalid locale','loco-translate') );
        }
        return $this->getName();
    }


    /**
     * Ensure locale has a label, even if it has to fall back to language code or error
     * @param Loco_api_WordPressTranslations
     * @return string
     */
    public function ensureName( Loco_api_WordPressTranslations $api ){
        $name = $this->getName();
        if( ! $name ){
            $name = $this->fetchName($api);
            // failing that, build own own name from components
            if( ! $name ){
                $name = $this->buildName();
                // last resort, use tag as name
                if( ! $name ){
                    $name = (string) $this;
                    $this->setName( $name );
                }
            }
        }
        return $name;
    }


    /**
     * @return array
     */
    #[ReturnTypeWillChange]
    public function jsonSerialize(){
        $a = $this->tag;
        $a['label'] = $this->getName();
        // plural data expected by editor
        $p = $this->getPluralData();
        $a['pluraleq'] = $p[0];
        $a['plurals'] = $p[1];
        $a['nplurals'] = count($p[1]);
        // tone setting may used by some external translation providers
        $a['tone'] = $this->getFormality();
        return $a;
    }


    /**
     * Get plural data with translated forms
     * @internal
     * @return array [ (string) equation, (array) forms ]
     */
    public function getPluralData(){
        $cache = $this->plurals;
        if( ! $cache ){
            $lc = $this->lang;
            $db = Loco_data_CompiledData::get('plurals');
            $id = $lc && isset($db[$lc]) ? $db[$lc] : 0;
            $cache = $this->setPlurals( $db[''][$id] );
        }
        return $cache;
    }


    /**
     * @param array[]
     * @return array
     */
    private function setPlurals( array $raw ){
        $raw = apply_filters( 'loco_locale_plurals', $raw, $this );
        // handle languages with no plural forms, where n is always 0
        if( ! isset($raw[1][1]) ){
            // Translators: Plural category for languages that have no plurals
            $raw[1] = array( _x('All forms','Plural category','loco-translate') );
            $raw[0] = '0';
        }
        // else translate all implemented plural forms
        // for meaning of categories, see http://cldr.unicode.org/index/cldr-spec/plural-rules
        else {
            $forms = array(
                // Translators: Plural category for zero quantity
                'zero' => _x('Zero','Plural category','loco-translate'),
                // Translators: Plural category for singular quantity
                'one' => _x('One','Plural category','loco-translate'),
                // Translators: Plural category used in some multi-plural languages
                'two' => _x('Two','Plural category','loco-translate'),
                // Translators: Plural category used in some multi-plural languages
                'few' => _x('Few','Plural category','loco-translate'),
                // Translators: Plural category used in some multi-plural languages
                'many' => _x('Many','Plural category','loco-translate'),
                // Translators: General plural category not covered by other forms
                'other' => _x('Other','Plural category','loco-translate'),
            );
            foreach( $raw[1] as $k => $v ){
                if( isset($forms[$v]) ){
                    $raw[1][$k] = $forms[$v];
                }
            }
        }
        $this->plurals = $raw;
        return $raw;
    }


    /**
     * Get PO style Plural-Forms header value comprising number of forms and integer equation for n
     * @return string
     */
    public function getPluralFormsHeader(){
        list( $equation, $forms ) = $this->getPluralData();
        return sprintf('nplurals=%u; plural=%s;', count($forms), $equation );
    }


    /**
     * Apply PO style Plural-Forms header.
     * @param string e.g. "nplurals=2; plural=n != 1;"
     * @return Loco_Locale
     */
    public function setPluralFormsHeader( $str ){
        if( ! preg_match('/^nplurals=(\\d);\s*plural=([ +\\-\\/*%!=<>|&?:()n0-9]+);?$/', $str, $match ) ){
            throw new InvalidArgumentException('Invalid Plural-Forms header, '.json_encode($str) );
        }
        $cache = $this->getPluralData();
        $exprn = $match[2];
        // always alter if equation differs
        if( $cache[0] !== $exprn ){
            $this->plurals[0] = $exprn;
            // alter number of forms if changed
            $nplurals = max( 1, (int) $match[1] );
            if( $nplurals !== count($cache[1]) ){
                // named forms must also change, but Plural-Forms cannot contain this information
                // as a cheat, we'll assume first form always "one" and last always "other"
                for( $i = 1; $i < $nplurals; $i++ ){
                    $name = 1 === $i ? 'one' : sprintf('Plural %u',$i);
                    $forms[] = $name;
                }
                $forms[] = 'other';
                $this->setPlurals( array($exprn,$forms) );
            }
        }
        return $this;
    }


    /**
     * Get formality setting, whether implied or explicit.
     * @return string either "", "formal" or "informal"
     */
    public function getFormality(){
        $value = '';
        $tag = $this->__toString();
        $variant = $this->variant;
        if( '' === $variant ){
            // if a formal variant exists, tone may be implied informal
            $d = Loco_data_CompiledData::get('locales');
            if( $d->offsetExists($tag.'_formal') ){
                if( ! $d->offsetExists($tag.'_informal') ) {
                    $value = 'informal';
                }
            }
            // if an informal variant exists, tone may be implied formal
            else if( $d->offsetExists($tag.'_informal') ){
                if( ! $d->offsetExists($tag.'_formal') ) {
                    $value = 'formal';
                }
            }
        }
        else if( 'formal' === $variant || 'informal' === $variant ){
            $value = $variant;
        }
        return apply_filters('loco_locale_formality',$value,$tag);
    }

}



// Depends on compiled library
if( ! function_exists('loco_parse_wp_locale') ){
    loco_require_lib('compiled/locales.php');
}

