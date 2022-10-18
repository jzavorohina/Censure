# CENSURE CLASS
Dirty words - filter. Filter out vulgar, obscene, profane words in Russian/English texts.

### Key features:
Fully covers the profanity words.

### Some examples
```php
// Searches if there any abusive words in the text
Censure::is_bad('Original phrase with abusive words'); // return: bool

// Replace abusive words from string
Censure::replace('Original phrase with abusive words'); // return: string (text without abusive words)

// Clean indexes in $_POST from abusive words
Censure::cleanPost('Unlimited number of arguments to match indexes in $_POST to clean'); // return: void
```
