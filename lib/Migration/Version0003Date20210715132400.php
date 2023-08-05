<?php
namespace OCA\DuplicateFindx\Migration;

use Closure;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
// This is OCP\DB\Types is support on NC 21 but not on NC 20
//use OCP\DB\Types;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\SimpleMigrationStep;
use OCP\Migration\IOutput;

class Version0003Date20210715132400 extends SimpleMigrationStep
{

  /**
  * @param IOutput $output
  * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
  * @param array<mixed> $options
  * @return null|ISchemaWrapper
  */
    public function changeSchema(IOutput $output, Closure $schemaClosure, array $options)
    {
      /** @var ISchemaWrapper $schema */
        $schema = $schemaClosure();
        if ($schema->hasTable('duplicatefindx_finfo')) {
            $table = $schema->getTable('duplicatefindx_finfo');
            if ($table->hasIndex('duplicatefindx_path_idx')) {
                $table->dropIndex('duplicatefindx_path_idx');
            }
            if (!$table->hasColumn('path_hash')) {
                $table->addColumn('path_hash', 'string', [
                  'notnull' => false,
                  'length' => 40,
                ]);
            }
            if (!$table->hasIndex('duplicatefindx_ph_idx')) {
                $table->addIndex(['path_hash'], 'duplicatefindx_ph_idx');
            }
            return $schema;
        }
        return null;
    }
}
