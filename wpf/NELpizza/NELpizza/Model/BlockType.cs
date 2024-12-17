using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace NELpizza.Model
{
    [Table("BlockTypes")]
    internal class BlockType
    {
        [Key]
        public int BlockTypeID { get; set; }

        [Required, MaxLength(50)] // Name of block, like NoteBlock or Tripwire
        public string Name { get; set; } = string.Empty;

        public ICollection<CustomVariation> CustomVariations { get; set; } = new List<CustomVariation>();
        public ICollection<CustomModel_BlockType> CustomModelDataItems { get; set; } = new List<CustomModel_BlockType>();
    }
}