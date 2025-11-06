<?php
namespace App\Twig\Components;

use App\Entity\EntryPoint;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveResponder;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;

#[AsLiveComponent()]
class NewCategoryForm
{
    use ComponentToolsTrait;
    use DefaultActionTrait;
    use ValidatableComponentTrait;

    // #[LiveProp(writable: true)]
    // #[NotBlank]
    // public EntryPoint $entryPoint;

    // public ?\DateTimeImmutable $targetDate;

    public string $permitWatchId;
    public string $entryPointId;
    public string $targetDate;

    #[LiveAction]
    public function savePermitWatch(EntityManagerInterface $entityManager, LiveResponder $liveResponder): void
    {
        $this->validate();

        // $category = new Category();
        // $category->setName($this->name);
        // $entityManager->persist($category);
        // $entityManager->flush();

        // $this->dispatchBrowserEvent('modal:close');
        // $this->emit('category:created', [
        //     'category' => $category->getId(),
        // ]);

        // reset the validation in case the modal is opened again
        $this->resetValidation();
    }
}