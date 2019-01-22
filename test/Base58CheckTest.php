<?php

//declare(strict_types=1);

/**
 * @author  Russell Michell 2019 for Decentrica <russ@theruss.com>
 * @package Dcentrica\Bolt11
 */

namespace Dcentrica\Bitcoin\Base58Check\Test;

use PHPUnit\Framework\TestCase;
use Dcentrica\Bitcoin\Base58Check\Base58Check;

/**
 * 
 */
class Base58CheckTest extends TestCase
{
    public function testLeadingzEncode()
    {
        $base58Check = new Base58Check('bitcoin');
        $data = $base58Check->encode('\x00\x00hello world');
        $this->assertEquals('11StV1DL6CwTryKyV', $data);
    }
    
    public function testLeadingzDecode()
    {
        $base58Check = new Base58Check('bitcoin');
        $data = $base58Check->decode('11StV1DL6CwTryKyV');
        $this->assertEquals('\x00\x00hello world', $data);
    }
    
    public function testLeadingzDecodeBytes()
    {
        $base58Check = new Base58Check('bitcoin');
        $data = $base58Check->decode('11StV1DL6CwTryKyV');
        $this->assertEquals('\x00\x00hello world', $data);
    }
    
}
