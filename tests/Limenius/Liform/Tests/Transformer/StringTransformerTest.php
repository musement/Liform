<?php

/*
 * This file is part of the Limenius\Liform package.
 *
 * (c) Limenius <https://github.com/Limenius/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Limenius\Liform\Tests\Liform\Transformer;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Limenius\Liform\Transformer\CompoundTransformer;
use Limenius\Liform\Transformer\StringTransformer;
use Limenius\Liform\Transformer\EmailTransformer;
use Limenius\Liform\Resolver;
use Limenius\Liform\Tests\LiformTestCase;
use Limenius\Liform\Transformer\TransformerInterface;

/**
 * @author Nacho Martín <nacho@limenius.com>
 *
 * @see TypeTestCase
 */
class StringTransformerTest extends LiformTestCase
{
    public function testPattern()
    {
        $form = $this->factory->create(FormType::class)
            ->add(
                'firstName',
                TextType::class,
                ['attr' => ['pattern' => '.{5,}' ]]
            );
        $transformed = $this->transformFrom(
            $this->resolverFrom('text', new StringTransformer($this->translator)),
            $form
        );
        $this->assertTrue(is_array($transformed));
        $this->assertEquals('.{5,}', $transformed['properties']['firstName']['pattern']);
    }

    public function testFormatIsSet()
    {
        $form = $this->factory->create(FormType::class)
            ->add(
                'userEmail',
                EmailType::class
            );
        $transformed = $this->transformFrom(
            $this->resolverFrom('email', new EmailTransformer($this->translator)),
            $form
        );
        $this->assertTrue(is_array($transformed));
        $this->assertEquals('string', $transformed['properties']['userEmail']['type']);
        $this->assertEquals('email', $transformed['properties']['userEmail']['format']);
    }

    private function resolverFrom($type, TransformerInterface $transformer)
    {
        $resolver = new Resolver();
        $resolver->setTransformer($type, $transformer);

        return $resolver;
    }    

    private function transformFrom(Resolver $resolver, $form)
    {
        $transformer = new CompoundTransformer($this->translator, null, $resolver);

        return $transformer->transform($form);
    }
}
