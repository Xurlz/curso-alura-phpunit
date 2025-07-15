alura-course-phpunit
--
Vinicius Dias's course [PHP e TDD: testes com PHPUnit](https://cursos.alura.com.br/course/phpunit-tdd) project containerized replication.

### How to use

```bash
docker run --rm -it --mount=type=bind,source=$(pwd),target=/tmp ghcr.io/xurlz/curso-alura-phpunit:lastest
```

There will be a stdout result: and two output files: `executed-tests.txt`, `executed-tests.html`

[![asciicast](https://asciinema.org/a/VFvbbn1vGngv2BP0sqcHDzOs2.svg)](https://asciinema.org/a/VFvbbn1vGngv2BP0sqcHDzOs2)

