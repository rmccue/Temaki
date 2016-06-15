# Temaki

A hand-rolled gettext Plural-Forms parser.

## Features

Temaki is designed to be both safe and performant. Only whitelisted operations are permitted.

Temaki also includes a tiny piece of optional caching. Plural form functions are typically called very often, but with the same input, so Temaki automatically [memoizes](https://en.wikipedia.org/wiki/Memoization) the call for future requests. With memoization enabled, Temaki matches the performance of a naive `eval` or `create_function` call.

Sample benchmark (single generation, 10k execution iterations):

<table>
	<thead>
		<tr>
			<th>Expr</th>
			<th><code>eval</code></th>
			<th><a href="https://github.com/zendframework/zend-i18n">ZF2</a></th>
			<th>Temaki (uncached)</th>
			<th>Temaki (cached)</th>
		</tr>
	</thead>
	<tr>
		<td>Arabic: <code>(n==0 ? 0 : n==1 ? 1 : n==2 ? 2 : n%100>=3 && n%100<=10 ? 3 : n%100>=11 ? 4 : 5)</code></td>
		<td>0.003</td>
		<td>0.131</td>
		<td>0.208</td>
		<td>0.002</td>
	</tr>
	<tr>
		<td>English: <code>(n != 1)</code></td>
		<td>0.002</td>
		<td>0.014</td>
		<td>0.018</td>
		<td>0.002</td>
	</tr>
	<tr>
		<td>Persian: <code>0</code></td>
		<td>0.002</td>
		<td>0.006</td>
		<td>0.009</td>
		<td>0.001</td>
	</tr>
	<tr>
		<td>Russian: <code>(n%10==1 && n%100!=11 ? 0 : n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2)</code></td>
		<td>0.004</td>
		<td>0.140</td>
		<td>0.185</td>
		<td>0.002</td>
	</tr>
</table>

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

## License

Temaki is licensed under the ISC License (similar to the new BSD license) and has no dependencies except for PHP 5.2+.

> Copyright (c) 2016 Ryan McCue and contributors
>
> Permission to use, copy, modify, and/or distribute this software for any
> purpose with or without fee is hereby granted, provided that the above
> copyright notice and this permission notice appear in all copies.
>
> THE SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
> WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
> MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
> ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
> WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
> ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
> OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
