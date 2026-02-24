<?php

class m250308_000004_seed_books_authors extends CDbMigration
{
	public function safeUp(): void
	{
        $j = 1;
        foreach (range(1, 1000) as $i) {
            $characters = 'abcdefg hijklmnopq rstuvwxy-zABCDEFGH IJKLMNOPQRST-UVWXYZ0';  
            $randomString = str_shuffle($characters);  
            $lastName = substr($randomString, 0, random_int(5, 15));
            $firstName = substr($randomString, 10, random_int(5, 15));
            $middleName = substr($randomString, 20, random_int(5, 15));

            $this->insert('author', array(
			'id' => $i,
			'last_name' => $lastName,
			'first_name' => $firstName,
			'middle_name' => $middleName,
		    ));

            $title = substr($randomString, 5, random_int(9, 25));
            $this->insert('book', array(
			'id' => $i,
            'isbn' => '978-5-' . random_int(100, 999999) . '-' . random_int(10, 999999) . '-0',
			'title' => $title,
			'year' => 1990 + random_int(0, 30),
			'description' => substr($randomString, 15, random_int(25, 46)),			
			'image_url' => '/images/' . $title,
		    ));

            $this->insert('book_author', [
                'id' => $j,
                'book_id' => $i,
                'author_id' => $i,
            ]);

            $j++;
            
            if ($i % 2 === 0) { 
                $this->insert('book_author', [
                    'id' => $j,
                    'book_id' => $i,
                    'author_id' => $i - 1,
                ]);
                $j++;
            }
        }        
    }

	public function safeDown(): void
	{
		$this->delete('book_author', 'book_id IN (' . implode(',', range(1, 1500)) . ')');
		$this->delete('book', 'id IN (' . implode(',', range(1, 1000)) . ')');
		$this->delete('author', 'id IN (' . implode(',', range(1, 1000)) . ')');
	}
}