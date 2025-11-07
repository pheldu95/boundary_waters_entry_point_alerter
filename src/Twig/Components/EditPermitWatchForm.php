<?php

namespace App\Twig\Components;

use App\Entity\EntryPoint;
use App\Entity\PermitWatch;
use App\Repository\EntryPointRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent()]
class EditPermitWatchForm extends AbstractController
{
    use DefaultActionTrait;
    use ValidatableComponentTrait;
    use ComponentToolsTrait;

    public function __construct(private EntryPointRepository $entryPointRepository) {}

    public function mount(): void
    {
        if ($this->permitWatch) {
            $this->entryPoint = $this->permitWatch->getEntryPoint();
            $this->targetDate = $this->permitWatch->getTargetDate()?->format('Y-m-d');
        }
    }

    #[LiveProp(writable: true)]
    #[NotBlank]
    public EntryPoint $entryPoint;

    #[LiveProp(writable: true)]
    #[NotBlank]
    public string $targetDate;

    #[LiveProp]
    public ?PermitWatch $permitWatch = null;

    #[ExposeInTemplate]
    public function getEntryPoints(): array
    {
        return $this->entryPointRepository->findAll();
    }

    public function isCurrentEntryPoint(EntryPoint $entryPoint): bool
    {
        return $this->entryPoint && $this->entryPoint === $entryPoint;
    }

    #[LiveAction]
    public function savePermitWatch(EntityManagerInterface $entityManager)
    {
        $this->validate();

        $this->permitWatch->setEntryPoint($this->entryPoint);
        
        $targetDate = \DateTimeImmutable::createFromFormat('Y-m-d', $this->targetDate);
        $this->permitWatch->setTargetDate($targetDate);
        
        $entityManager->persist($this->permitWatch);
        $entityManager->flush();

        // $this->dispatchBrowserEvent('modal:close');
        // $this->emit('category:created', [
        //     'category' => $category->getId(),
        // ]);

        // reset the validation in case the modal is opened again
        $this->resetValidation();

        $this->addFlash('success', 'Updated successfully');
        return $this->redirectToRoute('app_my_permit_watches');
    }
}
