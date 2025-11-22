<?php

namespace App\Services;

use App\Models\Person;

class PersonService
{
  /**
   * Retorna paginação de pessoas ordenadas por nome.
   *
   * @param int $perPage
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
   */
  public function paginate(int $perPage = 10)
  {
      return Person::orderBy('name')->paginate($perPage);
  }

  /**
   * Cria uma pessoa com os dados fornecidos.
   *
   * @param array $data
   * @return Person
   */
  public function create(array $data): Person
  {
    return Person::create($data);
  }

  /**
   * Carrega relacionamentos necessários para exibição (contacts).
   *
   * @param Person $person
   * @return Person
   */
  public function loadWithContacts(Person $person): Person
  {
    $person->load('contacts');
    return $person;
  }

  /**
   * Atualiza a pessoa com os dados fornecidos.
   *
   * @param Person $person
   * @param array $data
   * @return Person
   */
  public function update(Person $person, array $data): Person
  {
    $person->update($data);
    return $person;
  }

  /**
   * Executa o delete (soft delete) da pessoa.
   *
   * @param Person $person
   * @return void
   */
  public function delete(Person $person): void
  {
    $person->delete();
  }
}
