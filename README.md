# Temaki

A hand-rolled gettext Plural-Forms parser.

## Supported Syntax

Plural-Forms is a [subset of C syntax](https://www.gnu.org/software/gettext/manual/html_node/Plural-forms.html)

* Single variable `n`
* Integers (no floating point)
* Parentheses
* Modulo (`%`)
* Equality (`<`, `<=`, `>`, `>=`, `==`, `!=`, `&&`, `||`)
* Ternary (`a ? b : c`)

## Usage

```php
// Using Russian ruleset:
$handler = new Temaki( '(n%10==1 && n%100!=11 ? 0 : n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2)' );

$plural = $handler->get( 1 );
```

Temaki internally caches results in an array when using `get()` to avoid repeated calls to the translation ruleset, as a form of memoization. `execute()` can be called directly to skip the cache.
