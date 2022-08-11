<?php

namespace App\Traits\Trello;

trait HasUrlConstant
{
  private $baseUrl = 'https://api.trello.com/1/';
  private $meUrl = 'members/me/';
  private $organizationUrl = 'organizations/';
}
