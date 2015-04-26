<?php
/**
 * Created by PhpStorm.
 * User: Tzvetan
 * Date: 15-4-26
 * Time: 12:31
 */

namespace GFramework;

class ValidationRules {

    const REQUIRED = 'required';
    const MATCHES = 'matches';
    const MATCHES_STRICT = 'matchesStrict';
    const DIFFERENT = 'different';
    const DIFFERENT_STRICT = 'differentStrict';
    const MIN_LENGTH = 'minLength';
    const MAX_LENGTH = 'maxLength';
    const EXACT_LENGTH = 'exactLength';
    const GREATER = 'isGreater';
    const LOWER = 'isLower';
    const ALPHA = 'isAlpha';
    const ALPHA_NUM = 'isAlphaAndNum';
    const ALPHA_NUM_DASH = 'isAlphaAndNumAndDash';
    const NUMERIC = 'isNumeric';
    const EMAIL = 'isEmail';
    const URL = 'isUrl';
    const IP = 'isIp';
    const REGEXP = 'regexp';
    const CUSTOM = 'custom';
}