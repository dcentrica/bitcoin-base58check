<?php

/**
 * @author  Russell Michell for Dcentrica 2019 <russ@theruss.com>
 * @package Dcentrica\Base58Check
 */

namespace Dcentrica\Bitcoin\Base58Check;

use Tuupola\Base58;

/**
 * A Bitcoin specific base58check encoding/decoding library. A wrapper
 * around tuupola/base58 with the addition of SHA256 Bitcoin address checksum
 * verification.
 * 
 * @see https://en.bitcoin.it/wiki/Base58Check
 * @see https://github.com/tuupola/base58
 */
class Base58Check
{
    /**
     * The base58 implementation to use, according to $alphabet as passed to
     * the constructor.
     * 
     * @var Tuupola\Base58
     */
    protected $implementation;
    
    /**
     * @var string
     */
    protected $alphabet;
    
    /**
     * Return a base58check encode/decode service. Default alphabet is set to 'bitcoin'.
     * 
     * @param  string    $alphabet gmp|bitcoin|flickr|ripple|ipfs
     * @return void
     * @throws Exception
     */
    public function __construct(string $alphabet = 'bitcoin')
    {
        $const = strtoupper($alphabet);
        if (!in_array($const, self::alphabets(), true)) {
            throw new \Exception(sprintf('Invalid alphabet %s passed!', $alphabet));
        }
        
        $refl = new \ReflectionClass(Base58::class);
        $this->implementation = new Base58(['characters' => $refl->getConstant($const)]);
        $this->alphabet = $alphabet;
    }
    
    /**
     * Encode $data as base58.
     * 
     * @param  string $data THe data to be encoded.
     * @return string
     * @throws Exception
     * @todo Push Bitcoin address-specific data onto/into $data
     */
    public function encode(string $data) : string
    {
        return $this->implementation->encode($data);
    }
    
    /**
     * Decode $data from base58.
     * 
     * @param  string $data
     * @return string
     * @throws Exception
     */
    public function decode(string $data) : string
    {
        return $this->implementation->decode($data);
    }
    
    /**
     * Decode $data from base58, and verify it is intact via its checksum.
     * At present, only Bitcoin (addresses) are
     * checked. Other types will pass through and return true.
     * 
     * @param  string $data
     * @return string
     * @throws InvalidArgumentException
     * @see https://github.com/keis/base58/blob/master/base58.py#L107
     */
    public function decodeCheck(string $data) : string
    {
        if ($this->alphabet !== 'bitcoin') {
            return $data;
        }
        
        $decoded = $this->decode($data);
        
        list($result, $check) = [
            substr(0, (strlen($decoded) - 4), $decoded),                // Python: result[:-4]
            substr((strlen($decoded) - 4), strlen($decoded), $decoded), // Python: result[-4:]
        ];
        
        $digest = hash('sha256', hash('sha256', $result));
        
        if ($check !== substr(0, strlen($digest), $digest)) {
            throw new \InvalidArgumentException('Bad checksum in decoded data');
        }
        
        return $result;
    }
    
    /**
     * Checks $data for checksum. At present, only Bitcoin (addresses) are
     * checked. Other types will pass through and return true.
     * 
     * @param  string $data
     * @return string
     * @throws InvalidArgumentException
     * @todo
     * @see https://github.com/keis/base58/blob/master/base58.py#L100
     */
    public function encodeCheck(string $data) : string
    {
        if ($this->alphabet !== 'bitcoin') {
            return $data;
        }
    }
    
    /**
     * An array of legitimate alphabets.
     * 
     * @return array
     */
    private static function alphabets() : array
    {
        $consts = (new \ReflectionClass(Base58::class))->getConstants();
        
        return array_change_key_case(array_keys($consts), CASE_LOWER);
    }
    
}
