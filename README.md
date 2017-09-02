# censure
Filter abusive words in Russian.

### Some examples
```php
// Searches if there any abusive words in the text
Censure::is_bad('Original phrase with abusive words');

// Replace abusive words from string
Censure::replace('Original phrase with abusive words');

// Clean indexes in $_POST from abusive words
Censure::cleanPost('Unlimited number of arguments to match indexes in $_POST to clean'); 
```
