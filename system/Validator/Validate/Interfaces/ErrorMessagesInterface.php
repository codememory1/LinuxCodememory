<?php

namespace System\Validator\Validate\Interfaces;

interface ErrorMessagesInterface
{

    const ERR_MAX = '%s должен содержать максимум %s символов.';

    const ERR_MIN = '%s должен содержать минимум %s символов.';

    const ERR_BETWEEN = '%s должен содержать %s-%s символов.';

    const ERR_NUMERIC = '%s должен быть числом.';

    const ERR_RANGE_NUMBERS = '%s не должно быть меньше %s и больше %s.';

    const ERR_INTEGER = '%s должен содержать целое число.';

    const ERR_STRING = '%s должен быть строкой.';

    const ERR_BOOLEAN = '%s должен быть тип boolean(true,false,1,0).';

    const ERR_FRACTIONAL = '%s должно быть дробным числом.';

    const ERR_REQUIRED = '%s обязательно к заполнению.';

    const ERR_REQUIRED_IF_FILLED = '%s должно быть заполнено, в случае если %s заполнены.';

    const ERR_EMAIL = 'Некорректный Email.';

    const ERR_DATE = 'Некорректна дата.';

    const ERR_JSON = 'Некорректный Json формат.';

    const ERR_IP = 'Некорректный Ip-адрес';

    const ERR_REGULAR = '%s не соответствует регулярному выражению(%s).';

    const ERR_NOT_REGULAR = '%s не должно соответствовать регулярному выражению(%s).';

    const ERR_SAME = '%s не соответствует %s.';

    const ERR_ONLY = '%s должно содержать только: %s.';

    const ERR_ALPHA = '%s должно содержать латиские буквы.';

    const ERR_ALPHA_NUM = '%s должно содержать латиские буквы и цифры.';

    const ERR_ALPHA_DASH = '%s должно содержать латиские буквы, цифры и символы - _ =';

    const ERR_FASTDB_SERVER = 'Некорректный Ip сервера FastDB.';

    const ERR_URL = 'Некорректный Url-адрес.';

    const ERR_UNIQUE  = '%s уже существует.';

    const ERR_NOT_ONLY  = '%s не должно содержать: %s';

}