<?php
/**
 * Iowebsample:updateoptionCommand
 *
 * @copyright Copyright ©  Ioweb. All rights reserved.
 * @author
 */

namespace Ioweb\GithubSample\Console\Command;

use Magento\Catalog\Model\Product;
use Magento\Eav\Api\AttributeOptionManagementInterface;
use Magento\Eav\Model\Entity\Attribute\OptionFactory;
use Magento\Eav\Model\Entity\Attribute\OptionLabelFactory;
use Magento\Store\Model\Store;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateOptionCommand extends Command
{
    protected $attributeOptionManagement;
    protected $optionFactory;
    protected $optionLabelFactory;

    public function __construct(AttributeOptionManagementInterface $attributeOptionManagement, OptionFactory $optionFactory, OptionLabelFactory $optionLabelFactory)
    {
        $this->attributeOptionManagement = $attributeOptionManagement;
        $this->optionFactory = $optionFactory;
        $this->optionLabelFactory = $optionLabelFactory;
        parent::__construct();
    }

    public function configure()
    {
        $this->setName('iowebsample:updateoption')
            ->setDescription('')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $value = "test";
        $valueEN ="en_test";
        $valueGR = "gr_test";
        $order = 5;
        $entity = Product::ENTITY;
        $attributeCode = "myattribute";

        $output->writeln('Some actions here...');
        /** @var \Magento\Eav\Api\Data\AttributeOptionLabelInterface $label */
        $label = $this->optionLabelFactory->create();
        $label->setLabel($value);
        $label->setStoreId(Store::DEFAULT_STORE_ID);

        /** @var \Magento\Eav\Api\Data\AttributeOptionLabelInterface $label2 */
        $label2 = $this->optionLabelFactory->create();
        $label2->setLabel($valueEN);
        $label2->setStoreId(1);

        /** @var  $option \Magento\Eav\Model\Entity\Attribute\Option */
        $option = $this->optionFactory->create();
        $option->setStoreLabels([$label, $label2]);
        $option->setSortOrder($order);
        $option->setIsDefault(false);

        $optionId = $this->attributeOptionManagement->add($entity, $attributeCode, $option);
        $output->writeln(sprintf("Option id from attributeOptionManagement is %s", $optionId));
        $optionId2 = $option->getId();
        $output->writeln(sprintf("Option id from option object is %s", $optionId2));
    }
}