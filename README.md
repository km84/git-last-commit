Aplikacja oparta o ZendSkeletonApplication (Zend Framework 2.4.13)
------------

=======================

Instalacja
------------
    - pobrać kod z repozytorium Githuba https://github.com/km84/git-last-commit
    - w katalogu z projektem uruchomć polecenie `composer update`.

Uruchomienie
------------
`php public/index.php get-last-commit [--service=] repozytorium branch`,
np.
- `php public/index.php get-last-commit km84/git-last-commit master` lub
- `php public/index.php get-last-commit --service=github km84/git-last-commit master`
