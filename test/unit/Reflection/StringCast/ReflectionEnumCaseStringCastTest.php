<?php

declare(strict_types=1);

namespace Roave\BetterReflectionTest\Reflection\StringCast;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Roave\BetterReflection\Reflection\ReflectionEnum;
use Roave\BetterReflection\Reflection\StringCast\ReflectionEnumCaseStringCast;
use Roave\BetterReflection\Reflector\DefaultReflector;
use Roave\BetterReflection\SourceLocator\Ast\Locator;
use Roave\BetterReflection\SourceLocator\Type\SingleFileSourceLocator;
use Roave\BetterReflectionTest\BetterReflectionSingleton;
use Roave\BetterReflectionTest\Fixture\StringCastBackedEnum;
use Roave\BetterReflectionTest\Fixture\StringCastPureEnum;

#[CoversClass(ReflectionEnumCaseStringCast::class)]
class ReflectionEnumCaseStringCastTest extends TestCase
{
    private Locator $astLocator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->astLocator = BetterReflectionSingleton::instance()->astLocator();
    }

    public function testPureEnumCaseToString(): void
    {
        $reflector      = new DefaultReflector(new SingleFileSourceLocator(__DIR__ . '/../../Fixture/StringCastPureEnum.php', $this->astLocator));
        $enumReflection = $reflector->reflectClass(StringCastPureEnum::class);

        self::assertInstanceOf(ReflectionEnum::class, $enumReflection);
        self::assertSame("Constant [ public Roave\BetterReflectionTest\Fixture\StringCastPureEnum ENUM_CASE ] { Object }\n", (string) $enumReflection->getCase('ENUM_CASE'));
    }

    public function testPureEnumCaseWithDocCommentToString(): void
    {
        $reflector      = new DefaultReflector(new SingleFileSourceLocator(__DIR__ . '/../../Fixture/StringCastPureEnum.php', $this->astLocator));
        $enumReflection = $reflector->reflectClass(StringCastPureEnum::class);

        self::assertInstanceOf(ReflectionEnum::class, $enumReflection);
        self::assertSame("/**\n     * Something\n     */\nConstant [ public Roave\BetterReflectionTest\Fixture\StringCastPureEnum ENUM_CASE_WITH_DOC_COMMENT ] { Object }\n", (string) $enumReflection->getCase('ENUM_CASE_WITH_DOC_COMMENT'));
    }

    public function testBackedEnumCaseToString(): void
    {
        $reflector      = new DefaultReflector(new SingleFileSourceLocator(__DIR__ . '/../../Fixture/StringCastBackedEnum.php', $this->astLocator));
        $enumReflection = $reflector->reflectClass(StringCastBackedEnum::class);

        self::assertInstanceOf(ReflectionEnum::class, $enumReflection);
        self::assertSame("Constant [ public string ENUM_CASE ] { string }\n", (string) $enumReflection->getCase('ENUM_CASE'));
    }

    public function testBackedEnumCaseWithDocCommentToString(): void
    {
        $reflector      = new DefaultReflector(new SingleFileSourceLocator(__DIR__ . '/../../Fixture/StringCastBackedEnum.php', $this->astLocator));
        $enumReflection = $reflector->reflectClass(StringCastBackedEnum::class);

        self::assertInstanceOf(ReflectionEnum::class, $enumReflection);
        self::assertSame("/**\n     * Something\n     */\nConstant [ public string ENUM_CASE_WITH_DOC_COMMENT ] { something }\n", (string) $enumReflection->getCase('ENUM_CASE_WITH_DOC_COMMENT'));
    }
}
