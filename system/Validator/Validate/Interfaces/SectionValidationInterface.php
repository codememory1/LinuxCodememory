<?php

namespace System\Validator\Validate\Interfaces;

interface SectionValidationInterface
{

    const MULTIPLE_ARGUMENTS = '/^([\w]+)\:\((.*)\)$/i';

    const ARGUMENT = '/^([\w]+)\:(.*)$/i';

    const VALUE_MULTIPLE_ARGUMENT = '/^([\w]+)\=(.*)$/i';

}