# Kappa\Deaw

[![Build Status](https://travis-ci.org/Kappa-org/Deaw.svg)](https://travis-ci.org/Kappa-org/Deaw)

Tiny wrapper for better and more comfortable works with [dibi](http://dibiphp.com)

## Content
* [Requirements](#requirements)
* [Installation](#installation)
* [How to use](#how-to-use)
    * [Fetches](#fetches)
    * [Execute](#execute)
    * [Transactions](#transactions)
    * [Query objects](#query-objects)
* [Development](#development)
    * [Tests](#tests)
 
## Requirements

Full list of dependencies you can get from [Composer config file](https://github.com/Kappa-org/Deaw/blob/master/composer.json)

## Installation

The best way to install Kappa\Deaw is using [Composer](https://getcomposer.org)

```shell
$ composer require kappa/deaw:@dev
```

Before your first usage you must have registered `dibi` with required settings. 


```yaml
extensions:
  dibi: Dibi\Bridges\Nette\DibiExtension22
  
dibi:
  host: 127.0.0.1
  username: root
  password: 
  database: test
  driver: mysql
```

When you have `dibi` registered you can add `Kappa\Deaw` extension without any extra configuration (all configuration will be used from `dibi` package).

```yaml
extensions:
   dibi: Dibi\Bridges\Nette\DibiExtension22
   - \Kappa\Deaw\DI\DeawExtension
   
 dibi:
   host: 127.0.0.1
   username: root
   password: 
   database: test
   driver: mysql
```

## How to use

The basic principe of this package is combine [_domain queries_(cz)](https://www.rarous.net/weblog/377-domenove-dotazy.aspx) 
 and _`dibi` way_. This package provides a query objects which can be used for fetching or 
 executing queries and which is distributed into custom classes. 

Usage this package is very easy. `Kappa\Deaw` provides one base class `Kappa\Deaw\Table` for make works 
with `dibi` more comfortable. With this class you can make all fetches, executes and 
you can work with transactions.

Firstly, you can inject this class into your model

```php
class Users {
    
    private $table;
    
    public function __construct(\Kappa\Deaw\Table $table) {
        $this->table = $table;
    }
}
```

prepare the basic fetch query object which must implements 
 `\Kappa\Deaw\Query\Queryable` interface or for easy query objects you can use abstract
 class `\Kappa\Deaw\Query\QueryObject`

```php
class FetchAdminUsers extends QueryObject { // or implments Queryable 
    public function doQuery(QueryBuilder $builder) {
        return $builder->createQuery()->select('*')
            ->from('user')
            ->where('role = ?', 'admin');
    }
}
```

and now we can combine into model

```php
class Users {
    
    private $table;
    
    public function __construct(\Kappa\Deaw\Table $table) {
        $this->table = $table;
    }
    
    public function getAdmins() {
        return $this->table->fetch(new FetchAdminUsers());
    }
}
```

and it's all!

### Fetches

The basic fetch principe is explained above. You can use three methods for fetching data.

* `fetch` - for fetch all records (alternative to `fetchAll` from `dibi`)
* `fetchOne` - for fetch only one record (alternative to `fetch` from `dibi`)
* `fetchSingle` - for fetch single value (alternative to `fetchSingle` from `dibi`)

### Execute

You can also run executable query object for insert, update or remove data. For example:

```php
class AddNewAdminUser extends QueryObject
{
    private $name;
    
    public function __construct($name) {
        $this->name = $name;
    }
    
    public function doQuery(QueryBuilder $builder) {
        $builder->createQuery()->insert('users', [
            'name' => $this->name,
            'role' => 'admin'
        ]);
    }
}
```

and model

```php
class Users {
    
    private $table;
    
    public function __construct(\Kappa\Deaw\Table $table) {
        $this->table = $table;
    }
    
    public function addAdmin($name) {
        return $this->table->execute(new AddNewAdminUser($name));
    }
}
```

### Transactions

Also, you can use very easy transactions wrapper for typical `dibi` transactions.

We use `AddNewAdminUser` query object from previous example for example:

```php
class Users {
    
    private $table;
    
    public function __construct(\Kappa\Deaw\Table $table) {
        $this->table = $table;
    }
    
    public function addAdmins() {
        $this->table->transactional(function (Transaction $transaction) {
            try {
                $this->table->execute(new AddNewAdminUser('foo'));
                $this->table->execute(new AddNewAdminUser('bar'));
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollback();
            }
        });
    }
}
```

And of course you use savepoints (when is supported) 

```php
class Users {
    
    private $table;
    
    public function __construct(\Kappa\Deaw\Table $table) {
        $this->table = $table;
    }
    
    public function addAdmins() {
        $this->table->transactional(function (Transaction $transaction) {
            try {
                $this->table->execute(new AddNewAdminUser('foo'));                
                $this->table->execute(new AddNewAdminUser('bar'));
                $savepoint = $transaction->savepoint();
                try {
                    $this->table->execute(new AddNewAdminUser('foo_bar'));
                } catch (\Exception $e) {
                    $savepoint->rollback();
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollback();
            }
        });
    }
}
```

### Query objects

The basic query object provide `postFetch` method which is called after each fetch.
This method can be used for parsing data before return or for somethings else...

**TIP:** This method can be used for parsing to-many relations from string representation
into array, for example:

SQL:

```sql
CREATE TABLE `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `articles` (`id`, `user_id`, `title`) VALUES
(1,	1,	'Foo_article_1'),
(2,	1,	'Foo_article_2'),
(3,	2,	'Bar_article_1'),
(4,	2,	'Bar_article_2');

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

INSERT INTO `users` (`id`, `name`) VALUES
(1,	'Foo'),
(2,	'Bar');

```

```php
class FetchToMany implements Queryable {
    public function doQuery(QueryBuilder $builder) {
        return $builder->createQuery()
            ->select('users.id, users.name, GROUP_CONCAT(articles.title SEPARATOR ',') as articles')
            ->from('users');
    }
    
    public function postFetch($data) {
        foreach ($data as $key => $row) {
            $data[$key]['articles'] = explode(',', $data[$key]['articles'];
        }
        
        return $data;
    }
}
```

and results will be 

```php
    [
        [
            'id' => '1',
            'name' => 'Foo',
            'articles' => [
                'Foo_article_1',
                'Foo_article_2'
            ]
        ],
        [
            'id' => '2',
            'name' => 'Bar',
            'articles' => [
                'Bar_article_1',
                'Bar_article_2'
            ]
        ]
    ]
```

## Development

### Tests

When you can run test you must crate own config files. Please copy file
`tests/config/config.sample.neon`, rename to `config.neon` (remove `sample`
word) and update credentials in this file. Same do with
`tests/config/database.sample.ini`

And now you can run test `./vendor/bin/tests -c ./tests/php-unix.ini ./tests`
