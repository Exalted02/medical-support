<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Manage_chat;
use App\Events\ChatAssign;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AssignFreeEmployee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-free-employee';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign another employee if current employee not response.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $groupIds = Manage_chat::select('chat_group_id')
			->groupBy('chat_group_id')
			->havingRaw('COUNT(DISTINCT user_type) = 1')
			->havingRaw('MAX(user_type) = 1')
			->pluck('chat_group_id');

		$chats = Manage_chat::whereIn('chat_group_id', $groupIds)
			->where('created_at', '<=', Carbon::now()->subMinutes(32))
			->get();
		foreach($chats as $chat_val){
			$new_receiver = assignAnotherChatReceiverId($chat_val->receiver_id);
			$up = Manage_chat::where('chat_group_id', $chat_val->chat_group_id)->update(['receiver_id' => $new_receiver]);
			if($up){
				Log::info('New employee assign successfully.');
			}
			broadcast(new ChatAssign())->toOthers();
		}
		
		Log::info('Cronjob run successfully.');
        $this->info('New employee assign successfully.');
    }
}


?>