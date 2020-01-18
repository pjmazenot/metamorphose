<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Validators\Advanced;

use Metamorphose\Data\DataValidator;

class DateValidator extends DataValidator {

    const NAME = 'date';

    const TYPE_COMPARE = 'compare';
    const TYPE_FORMAT = 'format';

    public function validate($data, array $params = []): bool {

        if(count($params) < 2) {
            return false;
        }

        $type = array_shift($params);

        if($type === self::TYPE_COMPARE) {

            $compare = array_shift($params);
            $date = array_shift($params);

            $dataDatetime = new \DateTime($data);

            if(isset($date)) {

                if($date === 'now') {
                    $datetimeCompare = new \DateTime();
                } else {
                    $datetimeCompare = new \DateTime($date);
                }

                if($compare === 'lt') {

                    return $dataDatetime < $datetimeCompare;

                } elseif($compare === 'lte') {

                    return $dataDatetime <= $datetimeCompare;

                } elseif($compare === 'gte') {

                    return $dataDatetime >= $datetimeCompare;

                } elseif($compare === 'gt') {

                    return $dataDatetime > $datetimeCompare;

                }

            }

            return false;

        } elseif($type === self::TYPE_FORMAT) {

            $format = array_shift($params);

            $dataDatetime = new \DateTime($data);

            return $data === $dataDatetime->format($format);

        }

        return false;

    }

}
