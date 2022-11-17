<?php
    namespace APBPDN\Services;

    use DomainException;
    use Exception;

    class VideoService
    {
        
        /** @throws Exception */
        public static function pegaUlrDeIframe(string $iframe) : string
        {
            VideoService::validaIframe($iframe);

            preg_match('~<iframe.+src="([A-Za-z0-9/.:]+)".+>~', $iframe, $matches);

            return $matches[1];
        }

        /** @throws Exception */
        public static function validaIframe(string $iframe)
        {
            if(!preg_match('~<iframe.+src=".+".+>~', $iframe)){
                throw new Exception("iframe_invalido");
            };
        }

    }
    
?>