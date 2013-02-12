<?php
/*
 *  $Id$
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://www.doctrine-project.org>.
 */

/**
 * Doctrine_CustomPDOClass_TestCase
 *
 * @package     Doctrine
 * @author      Konsta Vesterinen <kvesteri@cc.hut.fi>
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @category    Object Relational Mapping
 * @link        www.doctrine-project.org
 * @since       1.0
 * @version     $Revision$
 */
class Doctrine_CustomPDOClass_TestCase extends Doctrine_UnitTestCase
{
    protected $__manager, $__dbh;
    
    /**
     * Don't mess with init()
     * 
     * @param string $pdoClass
     */
    protected function customInit($pdoClass)
    {
      $this->__manager = Doctrine_Manager::getInstance();
      $this->__manager->setAttribute(Doctrine_Core::ATTR_PDO_CLASS, $pdoClass);
      $this->__dbh = $this->__manager->openConnection('sqlite::memory:')->getDbh();
    }

    public function testAttributePdoClass()
    {
        $this->customInit('ExtendedPDO');
        $this->assertEqual($this->__manager->getAttribute(Doctrine_Core::ATTR_PDO_CLASS), 'ExtendedPDO');
    }

    public function testPdoClass()
    {
        $this->customInit('ExtendedPDO');
        $this->assertEqual(get_class($this->__dbh), 'ExtendedPDO');
    }

    public function testInvalidPdoClass()
    {
      try {
        $this->customInit('InvalidPDO');
        $this->fail();
      }
      catch(Doctrine_Connection_Exception $e)
      {
        $this->pass();
      }

    }
    
    public function tearDown()
    {
      parent::tearDown();
      
      Doctrine_Manager::resetInstance();
    }

}

class ExtendedPDO extends PDO {}
