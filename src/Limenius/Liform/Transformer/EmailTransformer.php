<?php

/*
 * This file is part of the Limenius\Liform package.
 *
 * (c) Limenius <https://github.com/Limenius/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Limenius\Liform\Transformer;

use Limenius\Liform\FormUtil;
use Limenius\Liform\Guesser\ValidatorGuesser;
use Symfony\Component\Form\FormInterface;

class EmailTransformer extends StringTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform(FormInterface $form, array $extensions = [])
    {
        $schema = parent::transform($form, $extensions);
        $schema['format'] = "email";

        return $schema;
    }

}
