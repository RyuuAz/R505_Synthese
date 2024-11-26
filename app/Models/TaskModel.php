namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'tsk_id';
    protected $allowedFields = ['usr_id', 'title', 'description', 'due_date'];
}
