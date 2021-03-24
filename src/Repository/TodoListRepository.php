<?php

namespace App\Repository;

use App\Entity\TodoList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TodoList|null find($id, $lockMode = null, $lockVersion = null)
 * @method TodoList|null findOneBy(array $criteria, array $orderBy = null)
 * @method TodoList[]    findAll()
 * @method TodoList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodoListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TodoList::class);
    }

    // /**
    //  * @return TodoList[] Returns an array of TodoList objects
    //  */
    public function fetchLiveTodoItems()
    {
        return $this->createQueryBuilder('todoList')
            ->andWhere('todoList.deleted = :deleted')
            ->setParameter('deleted', '0')
            ->addOrderBy('todoList.completed', 'ASC')
            ->addOrderBy('todoList.important', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
