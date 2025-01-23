using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NELpizza.Model
{
    [Table("klant_user")]
    public class KlantUser
    {
        [ForeignKey("Klant")]
        [Column("klant_id", TypeName = "BIGINT UNSIGNED")]
        public long KlantId { get; set; }
        public virtual Klant? Klant { get; set; }

        [ForeignKey("User")]
        [Column("user_id", TypeName = "BIGINT UNSIGNED")]
        public long UserId { get; set; }
        public virtual User? User { get; set; }
    }
}