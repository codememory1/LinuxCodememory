<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\MigrationInterfaces;

interface ErrorRequestInterface
{

    const ERR_404 = 'The request failed. Invalid request data.';

    const ERR_403 = 'The request failed. You are not authorized to perform this action.';

}