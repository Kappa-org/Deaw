# Kappa\Deaw

[![Build Status](https://travis-ci.org/Kappa-org/Deaw.svg)](https://travis-ci.org/Kappa-org/Deaw)

Simple library for more easy and comfortable works with [dibi](http://dibiphp.com)
 
## Requirements

Full list of dependencies you can get from [Composer config file](https://github.com/Kappa-org/Deaw/blob/master/composer.json)

## Installation

The best way to install Kappa\Deaw is using [Composer](https://getcomposer.org)

```shell
$ composer require kappa/deaw:@dev
```

and register extension

```yaml
extensions:
    deaw: Kappa\Deaw\DI\DeawExtension
```

You must not register [dibi](http://dibiphp.com) this package takes care about everything. Only one thins which you must
 do is added required database connection
  
```yaml
deaw:
	connection:
		host: 127.0.0.1
		username: root
		password: 
		database: test
		driver: mysql
```

## Configuration

```yaml
deaw:
	connection:
		host: 127.0.0.1
		username: root
		password: 
		database: test
		driver: mysql
	tables:
		- user
		- account
```

* `connection` - database connection
* `tables` - register tables, put its names

## Example

Define basic selectors

```php
class UserSelector extends Selector
{
	public function configure()
	{
		$this->setSelects([
			'name',
			'age',
		]);
	}
}

class RoleSelector extends Selector
{
	public function configure()
	{
		$this->setSelects(['name']);
	}
}
```

Now you can define query objects

```php
class GetUserById implements Queryable
{
	private $id;
	
	public function __construct($id)
	{
		$this->id = $id;
	}
	
	public function getBuilder(QueryBuilder $builder)
	{
		$query = $builder->select([new UserSelector(null, 'user'), new RoleSelector('roles', 'role')])
			->where('id = ?', $this->id);

		return $query;
	}
}

class GetAllUsers implements Queryable
{
	public function getBuilder(QueryBuilder $builder)
	{
		$query = $builder->select(new SelectAll());

		return $query;
	}
}

class DeleteUser implements Queryable
{
	private $id;
	
	public function __construct($id)
	{
		$this->id = $id;
	}
	
	public function getBuilder(QueryBuilder $builder)
	{
		$query = $builder->delete()
			->where('id = ?', $this->id);

		return $query;
	}
}

class UpdateUser implements Queryable
{
	private $id;
	
	private $data;
	
	public function __construct($id, array $data)
	{
		$this->id = $id;
		$this->data = $data;
	}
	
	public function getBuilder(QueryBuilder $builder)
	{
		$query = $builder->update($this->data)
			->where('id = ?', $this->id);

		return $query;
	}
}

class CreateUser implements Queryable
{
	private $data;
	
	public function __construct(array $data)
	{
		$this->data = $data;
	}
	
	public function getBuilder(QueryBuilder $builder)
	{
		$query = $builder->insert($this->data);

		return $query;
	}
}
```

```php
class UserManager
{
	private $usersTable;
	
	public function __construct(TableManager $tableManager)
	{
		$this->usersTable = $tableManager->getTable('users');
	}
	
	public function getUser($id)
	{
		return $this->usersTable->fetchOne(new GetUserById($id));
		/**
			return data in format
				user_name, user_age, role_name
		*/
	}
	
	public function getUsers()
	{
		return $this->usersTable->fetchAll(new GetAllUsers());
	}
	
	public function deleteUser($id)
	{
		$this->usersTable->execute(new DeleteUser($id));
	}
	
	public function updateUser($id, array $data)
	{
		$this->usersTable->execute(new UpdateUser($id, $data));
	}
	
	public function createUser(array $data)
	{ 
		$this->usersTable->execute(new CreateUser($data));
	}
}
```

