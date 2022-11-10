<?php
    namespace APBPDN\Helpers;

    use DateTimeInterface;
    use DateTime;
    use DateTimeZone;

    class DateHelper
    {
        public static function dataEHoraAtual(): DateTime
        {
            $timezone = new DateTimeZone('America/Sao_Paulo');
            return new DateTime('now', $timezone);
        }

        public static function formataDataEHora(DateTimeInterface $data): string
        {
            return $data->format("Y-m-d H:i:s");
        }
    }

?>