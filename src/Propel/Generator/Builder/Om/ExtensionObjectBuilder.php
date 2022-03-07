<?php

/**
 * MIT License. This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Propel\Generator\Builder\Om;

/**
 * Generates the empty stub object class for user object model (OM).
 *
 * This class produces the empty stub class that can be customized with application
 * business logic, custom behavior, etc.
 *
 * @author Hans Lellelid <hans@xmpl.org>
 */
class ExtensionObjectBuilder extends AbstractObjectBuilder
{
    /**
     * Returns the name of the current class being built.
     *
     * @return string
     */
    public function getUnprefixedClassName(): string
    {
        return $this->getTable()->getPhpName();
    }

    /**
     * Adds class phpdoc comment and opening of class.
     *
     * @param string $script The script will be modified in this method.
     *
     * @return void
     */
    protected function addClassOpen(&$script): void
    {
        $table = $this->getTable();
        $tableName = $table->getName();
        $tableDesc = $table->getDescription();
        $baseClassName = $this->getClassNameFromBuilder($this->getObjectBuilder());

        if ($this->getBuildProperty('generator.objectModel.addClassLevelComment')) {
            $script .= "
/**
 * Skeleton subclass for representing a row from the '$tableName' table.
 *
 * $tableDesc
 *";
            if ($this->getBuildProperty('generator.objectModel.addTimeStamp')) {
                $now = strftime('%c');
                $script .= "
 * This class was autogenerated by Propel " . $this->getBuildProperty('general.version') . " on:
 *
 * $now
 *";
            }
            $script .= "
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 */";
        }
        $script .= PHP_EOL . ($table->isAbstract() ? 'abstract ' : '') . 'class ' . $this->getUnqualifiedClassName() . " extends $baseClassName
{
";
    }

    /**
     * Specifies the methods that are added as part of the stub object class.
     *
     * By default there are no methods for the empty stub classes; override this method
     * if you want to change that behavior.
     *
     * @see ObjectBuilder::addClassBody()
     *
     * @param string $script
     *
     * @return void
     */
    protected function addClassBody(&$script): void
    {
    }

    /**
     * Closes class.
     *
     * @param string $script The script will be modified in this method.
     *
     * @return void
     */
    protected function addClassClose(&$script): void
    {
        $script .= "
}
";
        $this->applyBehaviorModifier('extensionObjectFilter', $script, '');
    }
}
