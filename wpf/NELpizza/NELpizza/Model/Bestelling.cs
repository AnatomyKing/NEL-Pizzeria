using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations.Schema;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Numerics;
using System.Text;
using System.Threading.Tasks;

namespace NELpizza.Model
{
    [Table("bestellings")]
    public class Bestelling
    {
        [Key]
        public long id { get; set; }

        public DateTime datum { get; set; }

        [Required]
        public BestelStatus status { get; set; }

        [ForeignKey("klant")]
        public long klant_id { get; set; }
        public virtual Klant? klant { get; set; }

        public virtual ICollection<Bestelregel> Bestelregels { get; set; } = new HashSet<Bestelregel>();
    }
}