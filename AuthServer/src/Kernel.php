<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

// TODO: Use gRPC for communication between NestJS and Symphony
class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
